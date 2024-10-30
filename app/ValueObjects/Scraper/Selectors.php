<?php

declare(strict_types=1);

namespace App\ValueObjects\Scraper;

use ArrayIterator;
use IteratorAggregate;

readonly class Selectors implements IteratorAggregate
{
    /** @param string[] $selectors */
    private function __construct(private array $selectors)
    {
    }

    /** @param string[] $selectors */
    public static function fromArray(array $selectors): self
    {
        return new self($selectors);
    }

    /** @return string[] */
    public function getValue(): array
    {
        return $this->selectors;
    }

    /** @return ArrayIterator */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->selectors);
    }
}
