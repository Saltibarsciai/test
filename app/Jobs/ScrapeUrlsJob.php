<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Builders\JobBuilder;
use App\Exceptions\ScrapingFailedException;
use App\Services\JobService;
use App\Services\ScrapingJobService;
use App\Services\ScrapingService;
use App\ValueObjects\Job\Job;
use App\ValueObjects\Job\Result;
use App\ValueObjects\Job\Status;
use App\ValueObjects\Scraper\ScrapedResult;
use Illuminate\Contracts\Queue\ShouldQueue;

class ScrapeUrlsJob implements ShouldQueue
{
    private Job $job;
    private ScrapingService $scrapingService;
    private ScrapingJobService $scrapingJobService;
    private JobService $jobService;

    private function __construct(Job $job)
    {
        $this->job = $job;
    }

    public function handle(): void
    {
        $this->scrapingService = app(ScrapingService::class);
        $this->scrapingJobService = app(ScrapingJobService::class);
        $this->jobService = app(JobService::class);

        if ($this->jobService->getStatus($this->job)->isCancelled()) {
            return;
        }

        $this->jobService->set(
            JobBuilder::fromJob($this->job)
                ->withStatus(Status::inProgress())
                ->build()
        );

        try {
            $result = ScrapedResult::fromString($this->job->getResult()->getValue());

            $html = $this->scrapingService->scrapeHtml($result);
            $scrapedData = $this->scrapingService->extractData($html, $result->getSelectors());

            $this->jobService->set(
                JobBuilder::fromJob($this->job)
                    ->withStatus(Status::completed())
                    ->withResult($result->withScrapedData($scrapedData))
                    ->build()
            );

        } catch (\Exception $e) {
            $this->jobService->set(
                JobBuilder::fromJob($this->job)
                    ->withStatus(Status::failed())
                    ->withResult(Result::fromString(ScrapingFailedException::fromException($e)->getMessage()))
                    ->build()
            );
        }
    }

    public static function create(Job $job): self
    {
        return new self($job);
    }
}

