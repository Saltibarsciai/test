<?php

declare(strict_types=1);

namespace App\ValueObjects\Scraper;

use ArrayIterator;
use IteratorAggregate;
use Webmozart\Assert\Assert;

readonly class Urls implements IteratorAggregate
{
    /** @param Url[] $urls */
    private function __construct(private array $urls)
    {
        Assert::allIsInstanceOf($urls, Url::class);
    }

    /** @param string[] $urls */
    public static function fromArray(array $urls): self
    {
        return new self(array_map(
            fn (string $url) => Url::fromString($url), $urls
        ));
    }

    /** @return ArrayIterator<Url> */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->urls);
    }

    /** @return Url[] */
    public function getValue(): array
    {
        return $this->urls;
    }
}
