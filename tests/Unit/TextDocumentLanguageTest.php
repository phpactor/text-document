<?php

namespace Phpactor\TextDocument\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Phpactor\TextDocument\TextDocumentLanguage;

class TextDocumentLanguageTest extends TestCase
{
    public function testCreate()
    {
        $language = TextDocumentLanguage::fromString('php');
        $this->assertEquals('php', (string) $language);
        $this->assertTrue($language->isDefined());
        $this->assertTrue($language->isPhp());
        $this->assertTrue($language->is('php'));
        $this->assertTrue($language->is('PHP'));
        $this->assertFalse($language->is('french'));
    }

    public function testCreateUndefined()
    {
        $language = TextDocumentLanguage::undefined();
        $this->assertFalse($language->isDefined());
    }
}
