<?php

declare(strict_types=1);

namespace App\Services;

use App\Clients\Contracts\HttpClientInterface;
use App\Crawlers\DomCrawler;
use App\ValueObjects\Scraper\Html;
use App\ValueObjects\Scraper\ScrapedData;
use App\ValueObjects\Scraper\ScrapedResult;
use App\ValueObjects\Scraper\Selectors;

readonly class ScrapingService
{
    public function __construct(private HttpClientInterface $client)
    {
    }

    public function scrapeHtml(ScrapedResult $scrapedResult): Html
    {
        $response = $this->client->get($scrapedResult->getUrl()->getValue());
        return Html::fromString((string) $response->getBody());
    }

    public function extractData(Html $html, Selectors $selectors): ScrapedData
    {
        $crawler = DomCrawler::fromHtml($html);
        $data = ScrapedData::createEmpty();
        foreach ($selectors as $selector) {
            $elements = $crawler->filter($selector);
            foreach ($elements as $element) {
                $data = $data->addForSelector($selector, $element->textContent);
            }
        }

        return $data;
    }
}
