<?php

declare(strict_types=1);

namespace App\Queue;

use App\ValueObjects\Job\QueueName;

class QueueList
{
    public static function getScrapingQueue(): QueueName
    {
        return QueueName::fromString('scraping_queue');
    }
}
