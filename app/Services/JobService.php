<?php

declare(strict_types=1);

namespace App\Services;

use App\Exceptions\JobNotFoundException;
use App\Repositories\Contracts\JobRepositoryInterface;
use App\ValueObjects\Job\Id;
use App\ValueObjects\Job\Job;
use App\ValueObjects\Job\QueueName;
use App\ValueObjects\Job\Status;

readonly class JobService
{
    public function __construct(private JobRepositoryInterface $jobRepository)
    {
    }

    public function set(Job $job): bool
    {
        return $this->jobRepository->set($job);
    }

    public function getStatus(Job $job): Status
    {
        return $this->jobRepository->getStatus($job);
    }

    /** @throws JobNotFoundException */
    public function get(Id $id, QueueName $queueName): Job
    {
        return $this->jobRepository->get($id, $queueName);
    }
}
