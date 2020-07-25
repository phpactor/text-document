<?php

namespace Phpactor\TextDocument;

use OutOfBoundsException;
use PHPUnit\Framework\MockObject\RuntimeException;

/**
 * Value object for line / column position.
 *
 * Lines and columns start with 1.
 *
 * The "a" in "abcd" would have line "1" and column "1".
 */
final class LineCol
{
    private const NEWLINE_PATTERN = '\\r\\n|\\n|\\r';

    /**
     * @var int
     */
    private $line;

    /**
     * @var int
     */
    private $col;

    public function __construct(int $line, int $col)
    {
        $this->line = $line;
        $this->col = $col;
    }

    public function toByteOffset(string $text): ByteOffset
    {
        $linesAndDelims = (array)preg_split('{(' . self::NEWLINE_PATTERN . ')}', $text, -1, PREG_SPLIT_DELIM_CAPTURE);

        if (count($linesAndDelims) === 0) {
            return ByteOffset::fromInt(
                strlen((string)reset($linesAndDelims))
            );
        }

        $lineNb = 0;
        $offset = 0;
        foreach ($linesAndDelims as $lineOrDelim) {
            $lineOrDelim = (string)$lineOrDelim;

            if ((bool)preg_match('{(' . self::NEWLINE_PATTERN . ')}', (string)$lineOrDelim)) {
                $lineNb++;
                $offset += strlen($lineOrDelim);
                continue;
            }

            if ($lineNb === $this->line()) {
                return ByteOffset::fromInt(
                    $offset + (int)strlen(
                        mb_substr($lineOrDelim, 0, $this->col())
                    )
                );
            }

            $offset += strlen((string)$lineOrDelim);
        }

        throw new OutOfBoundsException(sprintf(
            'Position %s:%s is larger than text length %s',
            $this->line(),
            $this->col(),
            strlen($text)
        ));
    }

    public static function fromByteOffset(string $text, ByteOffset $byteOffset): self
    {
        $lines = preg_split('{(' . self::NEWLINE_PATTERN . ')}', $text, -1, PREG_SPLIT_DELIM_CAPTURE);

        if (false === $lines) {
            throw new RuntimeException(
                'Failed to preg-split text into lines'
            );
        }

        $start = 0;
        $linesLength = 0;
        $lineNo = 0;
        foreach ($lines as $index => $line) {
            $end = $start + strlen($line);

            if (!preg_match('{^' . self::NEWLINE_PATTERN . '$}', $line)) {
                $lineNo++;
            }

            if ($byteOffset->toInt() >= $start && $byteOffset->toInt() < $end) {
                $section = substr($text, $start, $byteOffset->toInt() - $start);
                return new self($lineNo, mb_strlen($section));
            }

            $start = $end;
            $linesLength += mb_strlen($line);
        }

        throw new OutOfBoundsException(sprintf(
            'Byte offset %s is larger than text length %s',
            $byteOffset->toInt(),
            strlen($text)
        ));
    }

    public function col(): int
    {
        return $this->col;
    }

    public function line(): int
    {
        return $this->line;
    }
}
