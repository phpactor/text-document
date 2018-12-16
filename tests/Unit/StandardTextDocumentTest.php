<?php

namespace Phpactor\TextDocument\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Phpactor\TextDocument\Exception\InvalidUriException;
use Phpactor\TextDocument\Exception\TextDocumentNotFound;
use Phpactor\TextDocument\StandardTextDocument;

class StandardTextDocumentTest extends TestCase
{
    const EXAMPLE_TEXT = 'hello world';
    const EXAMPLE_URI = '/path/to';

    public function testCreate()
    {
        $doc = StandardTextDocument::fromLanguageAndText('php', self::EXAMPLE_TEXT, self::EXAMPLE_URI);
        $this->assertEquals(self::EXAMPLE_URI, $doc->uri());
        $this->assertEquals(self::EXAMPLE_TEXT, $doc->__toString());
    }

    public function testFromUri()
    {
        $doc = StandardTextDocument::fromUri('file://' . __FILE__);
        $this->assertEquals('file://' . __FILE__, $doc->uri());
        $this->assertEquals(file_get_contents(__FILE__), $doc->__toString());
    }

    public function testExceptionOnNotExists()
    {
        $this->expectException(TextDocumentNotFound::class);
        StandardTextDocument::fromUri('file:///i not exist');
    }
}
