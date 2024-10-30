<?php

declare(strict_types=1);

namespace App\Clients\Contracts;

use GuzzleHttp\Psr7\Response;

interface HttpClientInterface
{
    public function get(string $url): Response;
}
