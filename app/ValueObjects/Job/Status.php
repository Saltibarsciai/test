<?php

declare(strict_types=1);

namespace App\ValueObjects\Job;

use App\Exceptions\InvalidStatusException;

class Status
{
    public const STATUS_PENDING = 'pending';
    public const STATUS_IN_PROGRESS = 'in_progress';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_FAILED = 'failed';
    public const STATUS_CANCELED = 'canceled';

    private string $status;

    private function __construct(string $status)
    {
        $this->ensureIsValidStatus($status);
        $this->status = $status;
    }

    public static function pending(): self
    {
        return new self(self::STATUS_PENDING);
    }

    public static function fromString(string $value): self
    {
        return new self($value);
    }

    public static function inProgress(): self
    {
        return new self(self::STATUS_IN_PROGRESS);
    }

    public static function completed(): self
    {
        return new self(self::STATUS_COMPLETED);
    }

    public static function failed(): self
    {
        return new self(self::STATUS_FAILED);
    }

    public static function canceled(): self
    {
        return new self(self::STATUS_CANCELED);
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    /** @throws InvalidStatusException */
    private function ensureIsValidStatus(string $status): void
    {
        $validStatuses = [
            self::STATUS_PENDING,
            self::STATUS_IN_PROGRESS,
            self::STATUS_COMPLETED,
            self::STATUS_FAILED,
            self::STATUS_CANCELED,
        ];

        if (!in_array($status, $validStatuses, true)) {
            throw InvalidStatusException::fromStatus($status);
        }
    }

    public function isCancelled(): bool
    {
        return $this->status === self::STATUS_CANCELED;
    }

    public function isCancellable(): bool
    {
        return !in_array($this->status, [self::STATUS_IN_PROGRESS, self::STATUS_COMPLETED], true);
    }

    public function getValue(): string
    {
        return $this->status;
    }
}
