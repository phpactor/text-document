<?php

namespace Phpactor\TextDocument\Util;

use OutOfBoundsException;
use Phpactor\TextUtils\LineAtOffset as PhpactorLineAtOffset;
use RuntimeException;

final class LineAtOffset
{
    /**
     * @deprecated Use the TextUtils package.
     */
    public function __invoke(string $text, int $byteOffset): string
    {
        return PhpactorLineAtOffset::lineAtOffset($text, $byteOffset);
    }
}
