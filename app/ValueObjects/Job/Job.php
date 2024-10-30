<?php

declare(strict_types=1);

namespace App\ValueObjects\Job;

use App\Schemas\JobSchema;
use JsonSerializable;

readonly class Job implements JsonSerializable
{
    private function __construct(
        private Id $id,
        private Status $status,
        private Result $result,
        private QueueName $queueName
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            Id::fromString($data[JobSchema::ID]),
            Status::fromString($data[JobSchema::STATUS]),
            Result::fromArray($data[JobSchema::DATA]),
            QueueName::fromString($data[JobSchema::QUEUE_NAME])
        );
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function getStatus(): Status
    {
        return $this->status;
    }

    public function getResult(): Result
    {
        return $this->result;
    }

    public function getQueueName(): QueueName
    {
        return $this->queueName;
    }

    public function jsonSerialize(): string|false
    {
        return json_encode($this->toArray());
    }

    public function toArray(): array
    {
        return [
            JobSchema::ID => $this->getId()->getValue(),
            JobSchema::QUEUE_NAME => $this->getQueueName()->getValue(),
            jobSchema::STATUS => $this->getStatus()->getValue(),
            JobSchema::DATA => $this->getResult()->toArray(),
        ];
    }
}
