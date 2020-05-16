<?php


namespace Phpactor\TextDocument;

/**
 * This class is copied from the Tolerant Parser library.
 */
class TextEdit
{
    /**
     * @var int
     */
    private $start;

    /**
     * @var int
     */
    private $length;

    /**
     * @var string
     */
    private $replacement;

    private function __construct(int $start, int $length, string $content)
    {
        $this->start = $start;
        $this->length = $length;
        $this->replacement = $content;
    }

    public static function create(int $start, int $length, string $replacement): self
    {
        return new self($start, $length, $replacement);
    }

    public function end(): int
    {
        return $this->start + $this->length;
    }

    public function start(): int
    {
        return $this->start;
    }

    public function length(): int
    {
        return $this->length;
    }

    public function replacement(): string
    {
        return $this->replacement;
    }
}
