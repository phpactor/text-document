<?php

namespace Phpactor\TextDocument\Tests\Unit;

use Generator;
use PHPUnit\Framework\TestCase;
use Phpactor\TextDocument\LineCol;

class LineColTest extends TestCase
{
    /**
     * @dataProvider provideConvertLineColToOffset
     */
    public function testToByteOffset(string $text, LineCol $lineCol, int $expectedOffset, ?string $sanityCheck = null): void
    {
        $this->assertEquals($expectedOffset, $lineCol->toByteOffset($text)->toInt());
        if ($sanityCheck) {
            self::assertEquals($sanityCheck, substr($text, 0, $lineCol->toByteOffset($text)->toInt()));
        }
    }

    /**
     * @return Generator<mixed>
     */
    public function provideConvertLineColToOffset(): Generator
    {
        yield [
            '',
            new LineCol(0, 0),
            0,
        ];

        yield [
            'a',
            new LineCol(0, 1),
            1,
        ];

        yield 'new line' => [
            "\na",
            new LineCol(1, 1),
            2,
        ];

        yield 'multi-byte 1' => [
            "ᅑ",
            new LineCol(0, 1),
            3,
            "ᅑ",
        ];

        yield 'multi-byte 2' => [
            "ᅑacd",
            new LineCol(0, 2),
            4,
            "ᅑa"
        ];

        yield 'multi-byte 3' => [
            "ᅑ\nacd",
            new LineCol(1, 2),
            6,
            "ᅑ\nac"
        ];
    }
}
