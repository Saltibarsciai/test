<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Exceptions\JobNotFoundException;
use App\Exceptions\StatusNotFoundException;
use App\Repositories\Contracts\JobRepositoryInterface;
use App\Schemas\JobSchema;
use App\ValueObjects\Job\Id;
use App\ValueObjects\Job\Job;
use App\ValueObjects\Job\QueueName;
use App\ValueObjects\Job\Status;
use Illuminate\Support\Facades\Redis;

class RedisJobRepository implements JobRepositoryInterface
{
    public function set(Job $job): bool
    {
        return Redis::set("{$job->getQueueName()}:{$job->getId()}", $job->jsonSerialize());
    }

    public function getStatus(Job $job): Status
    {
        $key = "{$job->getQueueName()->getValue()}:{$job->getId()->getValue()}";
        $jobDataJson = Redis::get($key);

        if ($jobDataJson === false) {
            throw JobNotFoundException::fromIdAndQueue($job->getId(), $job->getQueueName());
        }

        $jobData = json_decode($jobDataJson, true);

        if (isset($jobData[JobSchema::STATUS])) {
            return Status::fromString($jobData[JobSchema::STATUS]);
        }

        throw StatusNotFoundException::fromIdAndQueue($job->getId(), $job->getQueueName());
    }

    /** @throws JobNotFoundException */
    public function get(Id $id, QueueName $queueName): Job
    {
        $entry = Redis::get("{$queueName->getValue()}:{$id->getValue()}");

        if ($entry === null)
        {
            throw JobNotFoundException::fromIdAndQueue($id, $queueName);
        }

        return Job::fromArray(json_decode($entry, true));
    }
}
