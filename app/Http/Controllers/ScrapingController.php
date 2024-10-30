<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Builders\JobBuilder;
use App\Exceptions\JobNotFoundException;
use App\Http\Requests\ScrapeCreateRequest;
use App\Queue\QueueList;
use App\Services\JobService;
use App\Services\ScrapingJobService;
use App\ValueObjects\Job\Id;
use App\ValueObjects\Job\Status;
use App\ValueObjects\Scraper\Selectors;
use App\ValueObjects\Scraper\Urls;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Redis;
use App\Http\Responses\JsonResponse as Response;

class ScrapingController extends Controller
{
    public function __construct(
        private readonly ScrapingJobService $scrapingJobService,
        private readonly JobService $jobService
    ) {
    }

    public function create(ScrapeCreateRequest $request): JsonResponse
    {
        $ids = $this->scrapingJobService->start(
            Urls::fromArray($request->input(ScrapeCreateRequest::URLS)),
            Selectors::fromArray($request->input(ScrapeCreateRequest::SELECTORS)),
        );

        return Response::success($ids->toArray());
    }

    public function show(string $id): JsonResponse
    {
        try {
            $jobData = $this->jobService->get(Id::fromString($id), QueueList::getScrapingQueue());
        } catch (JobNotFoundException $e) {
            return Response::notFound($e->getMessage());
        }

        return Response::success($jobData->toArray());
    }

    public function destroy(string $id): JsonResponse
    {
        try {
            $jobData = $this->jobService->get(Id::fromString($id), QueueList::getScrapingQueue());
        } catch (JobNotFoundException $e) {
            return Response::notFound($e->getMessage());
        }

        if (!$jobData->getStatus()->isCancellable())
        {
            return Response::unprocessable();
        }

        $this->jobService->set(JobBuilder::fromJob($jobData)->withStatus(Status::canceled())->build());

        return Response::success();
    }

    // temp helper controller
    public function index(): JsonResponse
    {
        $keys = Redis::keys('*');
        $data = [];

        foreach ($keys as $key) {
            $value = Redis::get($key);
            $data[$key] = json_decode($value, true);
        }

        return response()->json($data);
    }
}
