<?php

namespace Phpactor\TextDocument\Util;

use Phpactor\TextDocument\ByteOffset;
use Phpactor\TextDocument\TextDocument;

class WordAtOffset
{
    /**
     * @var array
     */
    private $breakingPattern;

    public function __construct(array $breakingPattern = [])
    {
        $this->breakingPattern = '\s|\\\|%|\(|\)|\[|\]|:|\r|\r\n|\n';
    }

    public function __invoke(string $text, int $offset)
    {
        $chars = [];
        $offset--;
        $originalOffset = $offset;
        $text = preg_split('{(' . $this->breakingPattern . ')}', $text, -1, PREG_SPLIT_DELIM_CAPTURE);

        $start = 0;
        foreach ($text as $chunk) {
            $end = $start + strlen($chunk);
            if ($offset < $end && $offset >= $start) {
                return $chunk;
            }
            $start = $end;
        }
    }
}
