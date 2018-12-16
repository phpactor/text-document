<?php

namespace Phpactor\TextDocument\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Phpactor\TextDocument\TextDocumentUri;

class TextDocumentUriTest extends TestCase
{
    public function testCreate()
    {
        $uri = TextDocumentUri::create(__FILE__);
        $this->assertEquals(__FILE__, (string) $uri);
    }

    public function testExceptionOnNonAbsolutePath()
    {
        $this->expectException(InvalidUriException::class);
        TextDocumentUri::fromString('i is relative');
    }
}
