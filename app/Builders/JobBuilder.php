<?php

declare(strict_types=1);

namespace App\Builders;

use App\Schemas\JobSchema;
use App\ValueObjects\Job\Id;
use App\ValueObjects\Job\Job;
use App\ValueObjects\Job\QueueName;
use App\ValueObjects\Job\Result;
use App\ValueObjects\Job\Status;

class JobBuilder
{
    private array $data;

    private function __construct(array $data = [])
    {
        $this->data = $data;
    }

    public static function create(): self
    {
        return new self([
            JobSchema::ID => Id::createNew()->getValue(),
            JobSchema::STATUS => Status::pending()->getValue(),
            JobSchema::DATA => Result::fromString('')->getValue(),
            JobSchema::QUEUE_NAME => QueueName::fromString('')->getValue(),
        ]);
    }

    public function withStatus(Status $status): self
    {
        return $this->with(JobSchema::STATUS, $status->getValue());
    }

    public function withQueueName(QueueName $queueName): self
    {
        return $this->with(JobSchema::QUEUE_NAME, $queueName->getValue());
    }

    public function withResult(Result $result): self
    {
        return $this->with(JobSchema::DATA, $result->getValue());
    }

    public static function fromJob(Job $job): self
    {
        return new self([
            JobSchema::ID => $job->getId()->getValue(),
            JobSchema::STATUS => $job->getStatus()->getStatus(),
            JobSchema::DATA => $job->getResult()->getValue(),
            JobSchema::QUEUE_NAME => $job->getQueueName()->getValue(),
        ]);
    }

    private function with(string $key, string $value): self
    {
        $values = $this->data;
        $values[$key] = $value;

        return new self($values);
    }

    public function build(): Job
    {
        return Job::fromArray([
            JobSchema::ID => $this->data[JobSchema::ID],
            JobSchema::STATUS => $this->data[JobSchema::STATUS],
            JobSchema::DATA => json_decode($this->data[JobSchema::DATA], true),
            JobSchema::QUEUE_NAME => $this->data[JobSchema::QUEUE_NAME],
        ]);
    }
}
