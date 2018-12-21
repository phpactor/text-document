<?php

namespace Phpactor\TextDocument\Util;

use OutOfBoundsException;

final class WordAtOffset
{
    /**
     * @var string
     */
    private $splitPattern;

    public function __construct(string $splitPattern = '\s|\\\|%|\(|\)|\[|\]|:|\r|\r\n|\n')
    {
        $this->splitPattern = $splitPattern;
    }

    public function __invoke(string $text, int $byteOffset): string
    {
        $chars = [];
        $byteOffset--;
        $originalOffset = $byteOffset;
        $text = preg_split('{(' . $this->splitPattern . ')}', $text, -1, PREG_SPLIT_DELIM_CAPTURE);

        $start = 0;
        foreach ($text as $chunk) {
            $end = $start + strlen($chunk);
            if ($byteOffset < $end && $byteOffset >= $start) {
                return $chunk;
            }
            $start = $end;
        }

        throw new OutOfBoundsException(sprintf(
            'Byte offset %s is larger than text length %s',
            $byteOffset,
            strlen($text)
        ));
    }
}
