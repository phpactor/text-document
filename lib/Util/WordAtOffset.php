<?php

namespace Phpactor\TextDocument\Util;

use OutOfBoundsException;
use Phpactor\TextUtils\WordAtOffset as PhpactorWordAtOffset;
use RuntimeException;

final class WordAtOffset
{
    public const SPLIT_WORD = PhpactorWordAtOffset::SPLIT_WORD;
    public const SPLIT_QUALIFIED_PHP_NAME = PhpactorWordAtOffset::SPLIT_QUALIFIED_PHP_NAME;

    /**
     * @var string
     */
    private $splitPattern;

    public function __construct(string $splitPattern = self::SPLIT_WORD)
    {
        $this->splitPattern = $splitPattern;
    }

    /**
     * @deprecated Use the TextUtils package.
     */
    public function __invoke(string $text, int $byteOffset): string
    {
        return (new PhpactorWordAtOffset($this->splitPattern))->__invoke($text, $byteOffset);
    }
}
