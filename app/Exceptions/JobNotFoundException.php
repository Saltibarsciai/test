<?php

declare(strict_types=1);

namespace App\Exceptions;

use App\ValueObjects\Job\Id;
use App\ValueObjects\Job\QueueName;
use Exception;

final class JobNotFoundException extends Exception
{
    public static function fromIdAndQueue(Id $id, QueueName $queueName): self
    {
        return new self(
            sprintf('Job with id %s not found in queue %s', $id->getValue(), $queueName->getValue())
        );
    }
}
