<?php

declare(strict_types=1);

namespace App\ValueObjects\Scraper;

use Webmozart\Assert\Assert;

readonly class Url
{
    private function __construct(private string $url)
    {
    }

    public static function fromString(string $url): self
    {
        Assert::contains($url, 'http');

        return new self($url);
    }

    public function getValue(): string
    {
        return $this->url;
    }
}
