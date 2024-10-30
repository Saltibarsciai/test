<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Exceptions\JobNotFoundException;
use App\ValueObjects\Job\Id;
use App\ValueObjects\Job\Job;
use App\ValueObjects\Job\QueueName;
use App\ValueObjects\Job\Status;

interface JobRepositoryInterface
{
    public function set(Job $job): bool;
    public function getStatus(Job $job): Status;

    /** @throws JobNotFoundException */
    public function get(Id $id, QueueName $queueName): Job;
}
