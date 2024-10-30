<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;

final class InvalidStatusException extends Exception
{
    public static function fromStatus(string $status): self
    {
        return new self(sprintf('Invalid status: %s', $status));
    }
}
