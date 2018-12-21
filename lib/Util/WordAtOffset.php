<?php

namespace Phpactor\TextDocument\Util;

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

    public function __invoke(string $text, int $offset)
    {
        $chars = [];
        $offset--;
        $originalOffset = $offset;
        $text = preg_split('{(' . $this->splitPattern . ')}', $text, -1, PREG_SPLIT_DELIM_CAPTURE);

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
