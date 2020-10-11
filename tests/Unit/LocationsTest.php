<?php

namespace Phpactor\TextDocument\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Phpactor\TextDocument\Location;
use Phpactor\TextDocument\Locations;
use RuntimeException;

class LocationsTest extends TestCase
{
    public function testContainsLocations(): void
    {
        $locations = new Locations([
            Location::fromPathAndOffset('/path/to.php', 12),
            Location::fromPathAndOffset('/path/to.php', 13)
        ]);
        $this->assertCount(2, $locations);
    }

    public function testIsCountable(): void
    {
        $locations = new Locations([
            Location::fromPathAndOffset('/path/to.php', 12),
            Location::fromPathAndOffset('/path/to.php', 13)
        ]);
        $this->assertEquals(2, $locations->count());
    }

    public function testExceptionIfFirstNotAvailable(): void
    {
        $this->expectException(RuntimeException::class);
        $locations = new Locations([
        ]);
        $locations->first();
    }

    public function testAppendLocations(): void
    {
        $locations = new Locations([
            Location::fromPathAndOffset('/path/to.php', 12),
        ]);
        $locations = $locations->append(new Locations([
            Location::fromPathAndOffset('/path/to.php', 13),
        ]));

        self::assertEquals(new Locations([
            Location::fromPathAndOffset('/path/to.php', 12),
            Location::fromPathAndOffset('/path/to.php', 13)
        ]), $locations);
    }

    public function testCreateSortedLocations(): void
    {
        $locationList = [
            Location::fromPathAndOffset('/path/to.php', 12),
            Location::fromPathAndOffset('/path/from.php', 13),
            Location::fromPathAndOffset('/path/to.php', 15),
        ];
        $locations = Locations::bySorting($locationList);

        $this->assertEquals([
            $locationList[1],
            $locationList[0],
            $locationList[2],
        ], iterator_to_array($locations));
    }

    /**
     * @dataProvider provideUnsortedLocations
     *
     * @param Location[] $unsortedLocations
     * @param Location[] $sortedLocations
     */
    public function testSortLocations(
        array $unsortedLocations,
        array $sortedLocations
    ): void {
        $locations = new Locations($unsortedLocations);

        $this->assertEquals($sortedLocations, iterator_to_array($locations->sort()));
    }

    /**
     * @return iterable<array>
     */
    public function provideUnsortedLocations(): iterable
    {
        yield '2 files and 3 references' => [[
            Location::fromPathAndOffset('/path/to.php', 15),
            Location::fromPathAndOffset('/path/to.php', 12),
            Location::fromPathAndOffset('/path/from.php', 13),
        ], [
            Location::fromPathAndOffset('/path/from.php', 13),
            Location::fromPathAndOffset('/path/to.php', 12),
            Location::fromPathAndOffset('/path/to.php', 15),
        ]];
    }
}
