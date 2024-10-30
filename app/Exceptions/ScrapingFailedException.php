<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Illuminate\Support\Str;
use Throwable;

final class ScrapingFailedException extends Exception
{
    public static function fromException(Throwable $throwable): self
    {
        return new self(Str::limit($throwable->getMessage(), 200));
    }
}
