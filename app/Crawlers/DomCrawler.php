<?php

declare(strict_types=1);

namespace App\Crawlers;

use App\ValueObjects\Scraper\Html;
use Symfony\Component\DomCrawler\Crawler;

class DomCrawler extends Crawler
{
    public static function fromHtml(Html $html): self
    {
        return new self($html->getValue());
    }
}
