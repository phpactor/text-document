<?php

namespace Phpactor\TextDocument\Tests\Unit\Util;

use PHPUnit\Framework\TestCase;
use Phpactor\TestUtils\ExtractOffset;
use Phpactor\TextDocument\Util\WordAtOffset;

class WordAtOffsetTest extends TestCase
{
    /**
     * @dataProvider provideWordAtOffset
     */
    public function testWordAtOffset(string $text, string $expectedWord)
    {
        [ $text, $offset ] = ExtractOffset::fromSource($text);

        $this->assertEquals($expectedWord, (new WordAtOffset())($text, --$offset));
    }

    public function provideWordAtOffset()
    {
        yield [
            'hello thi<>s is',
            'this',
        ];

        yield [
            'h<>ello this is',
            'hello',
        ];
        yield [
            'hello this i<>s',
            'is',
        ];
        yield [
            'hello this is<>',
            'is',
        ];
        yield [
            "hello this is\nsom<>ething",
            'something',
        ];
        yield [
            " <>  hello this is\nsom<>ething",
            ' ',
        ];
    }
}
