<?php

namespace Phpactor\TextDocument;

use ArrayIterator;
use Countable;
use IteratorAggregate;
use RuntimeException;

/**
 * @implements IteratorAggregate<Location>
 */
class Locations implements IteratorAggregate, Countable
{
    /**
     * @var Location[]
     */
    private $locations = [];

    /**
     * @param Location[] $locations
     */
    public function __construct(array $locations)
    {
        foreach ($locations as $location) {
            $this->add($location);
        }
    }

    /**
     * @return ArrayIterator<int,Location>
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->locations);
    }

    private function add(Location $location): void
    {
        $this->locations[] = $location;
    }

    public function count(): int
    {
        return count($this->locations);
    }

    public function first(): Location
    {
        if (count($this->locations) === 0) {
            throw new RuntimeException(
                'There are no locations in this collection'
            );
        }

        return reset($this->locations);
    }
}
