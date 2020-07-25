<?php

namespace Phpactor\TextDocument\Util;

use OutOfBoundsException;
use Phpactor\TextDocument\LineCol;
use Phpactor\TextUtils\LineColFromOffset as PhpactorLineColFromOffset;
use RuntimeException;

class LineColFromOffset
{
    /**
     * @deprecated Use the TextUtils package.
     */
    public function __invoke(string $document, int $byteOffset): LineCol
    {
        $lineCol = PhpactorLineColFromOffset::lineColFromOffset($document, $byteOffset);
        return new LineCol($lineCol->line(), $lineCol->col());
    }
}
