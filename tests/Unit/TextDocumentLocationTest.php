<?php

namespace Phpactor\TextDocument\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Phpactor\TextDocument\ByteOffset;
use Phpactor\TextDocument\TextDocumentBuilder;
use Phpactor\TextDocument\TextDocumentLocation;

class TextDocumentLocationTest extends TestCase
{
    public function testValues()
    {
        $document = TextDocumentBuilder::create('asd')->build();

        $offset = ByteOffset::fromInt(123);
        $location = new TextDocumentLocation($document, $offset);

        $this->assertSame($location->offset(), $offset);
        $this->assertSame($location->document(), $document);

    }
}
