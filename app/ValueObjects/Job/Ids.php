<?php

declare(strict_types=1);

namespace App\ValueObjects\Job;

use ArrayIterator;
use Webmozart\Assert\Assert;

readonly class Ids
{
    /** @param Id[] $ids */
    private function __construct(private array $ids)
    {
        Assert::allIsInstanceOf($ids, Id::class);
    }

    /** @param Id[] $ids */
    public static function fromArray(array $ids): self
    {
        return new self(array_map(
            fn (string $id) => Id::fromString($id), $ids
        ));
    }

    /** @return ArrayIterator<Id> */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->ids);
    }

    /** @return Ids[] */
    public function toArray(): array
    {
        return array_map(
            fn (Id $id) => $id->getValue(), $this->ids
        );
    }
}
