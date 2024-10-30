<?php

declare(strict_types=1);

namespace App\ValueObjects\Job;

use App\ValueObjects\StringableVo;

class Result extends StringableVo
{
    public static function fromArray(array $value): static
    {
        return self::fromString(json_encode($value));
    }
}
