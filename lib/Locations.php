<?php

namespace Phpactor\TextDocument;

use ArrayIterator;
use Countable;
use IteratorAggregate;
use RuntimeException;

/**
 * @implements IteratorAggregate<Location>
 */
final class Locations implements IteratorAggregate, Countable
{
    /**
     * @var Location[]
     */
    private $locations = [];

    /**
     * @param iterable<Location> $locations
     */
    public function __construct(iterable $locations)
    {
        foreach ($locations as $location) {
            $this->add($location);
        }
    }

    /**
     * @param iterable<Location> $locations
     */
    public static function bySorting(iterable $locations, ?callable $sortStrategy = null): self
    {
        return (new self($locations))->sorted($sortStrategy);
    }

    /**
     * @return ArrayIterator<int,Location>
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->locations);
    }

    public function append(Locations $locations): self
    {
        $newLocations = $this->locations;
        foreach ($locations as $location) {
            $newLocations[] = $location;
        }

        return new self($newLocations);
    }

    private function add(Location $location): self
    {
        $this->locations[] = $location;

        return $this;
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

    public function sorted(?callable $sortStrategy = null): self
    {
        usort($this->locations, $sortStrategy ?: self::defaultSortStrategy());

        return $this;
    }

    private static function defaultSortStrategy(): callable
    {
        return function (Location $first, Location $second) {
            $order = strcmp((string) $first->uri(), (string) $second->uri());
            if (0 !== $order) {
                return $order;
            }

            return $first->offset()->toInt() - $second->offset()->toInt();
        };
    }
}
