<?php

declare(strict_types=1);

namespace App\ValueObjects\Scraper;

class ScrapedData
{
    private function __construct(private array $data)
    {
    }
    public static function createEmpty(): self
    {
        return new self([]);
    }

    public function addForSelector(string $selector, string $content): self
    {
        $self = clone $this;

        if(isset($self->data[$selector])) {
            $self->data[$selector] = [];
        }
        $self->data[$selector][] = $content;

        return $self;
    }

    public function getValue(): array
    {
        return $this->data;
    }
}
