<?php

declare(strict_types=1);

namespace App\Schemas;

class JobSchema
{
    public const ID = 'id';
    public const STATUS = 'status';
    public const DATA = 'data';
    public const QUEUE_NAME = 'queue_name';
}
