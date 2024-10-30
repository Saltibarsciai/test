<?php

declare(strict_types=1);

namespace App\Services;

use App\Builders\JobBuilder;
use App\Jobs\ScrapeUrlsJob;
use App\Queue\QueueList;
use App\Repositories\Contracts\JobRepositoryInterface;
use App\ValueObjects\Job\Ids;
use App\ValueObjects\Scraper\ScrapedData;
use App\ValueObjects\Scraper\ScrapedResult;
use App\ValueObjects\Scraper\Selectors;
use App\ValueObjects\Scraper\Urls;
use Illuminate\Support\Facades\Queue;

readonly class ScrapingJobService
{
    public function __construct(private JobRepositoryInterface $jobRepository)
    {
    }

    public function start(Urls $urls, Selectors $selectors): Ids
    {
        $ids = [];
        foreach ($urls as $url) {
            $job = JobBuilder::create()
                ->withQueueName(QueueList::getScrapingQueue())
                ->withResult(ScrapedResult::create($url, $selectors, ScrapedData::createEmpty()))
                ->build();

            $this->jobRepository->set($job);
            Queue::pushOn($job->getQueueName()->getValue(), ScrapeUrlsJob::create($job));
            $ids[] = $job->getId();
        }

        return Ids::fromArray($ids);
    }
}
