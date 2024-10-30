<?php

declare(strict_types=1);

namespace App\ValueObjects\Scraper;

use App\ValueObjects\Job\Result;

class ScrapedResult extends Result
{
    private const URL = 'url';
    private const SELECTORS = 'selectors';
    private const SCRAPED_DATA = 'scraped_data';

    public static function create(Url $url, Selectors $selectors, ScrapedData $scrapedData): self
    {
        return self::fromString(
            json_encode([
                self::URL => $url->getValue(),
                self::SELECTORS => $selectors->getValue(),
                self::SCRAPED_DATA => $scrapedData->getValue()
            ])
        );
    }

    public function getUrl(): Url
    {
        $data = json_decode($this->getValue(), true);
        return Url::fromString($data[self::URL]);
    }

    public function getSelectors(): Selectors
    {
        $data = json_decode($this->getValue(), true);
        return Selectors::fromArray($data[self::SELECTORS]);
    }

    public function withScrapedData(ScrapedData $scrapedData): self
    {
        return self::fromString(
            json_encode([
                self::URL => $this->getUrl()->getValue(),
                self::SELECTORS => $this->getSelectors()->getValue(),
                self::SCRAPED_DATA => $scrapedData->getValue()
            ])
        );
    }
}
