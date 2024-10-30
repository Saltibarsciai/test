<?php

declare(strict_types=1);

namespace App\ValueObjects;

use Illuminate\Support\Str;

class StringableVo implements \Stringable
{
    private function __construct(private readonly string $value)
    {
    }

    public static function fromString(string $value): static
    {
        return new static($value);
    }

    public static function createNew(): static
    {
        return new static(Str::uuid()->toString());
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function toArray(): array
    {
        return json_decode($this->value, true);
    }

    public function __toString(): string
    {
        return $this->getValue();
    }
}
