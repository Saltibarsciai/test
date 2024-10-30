<?php

declare(strict_types=1);

namespace App\Clients;

use App\Clients\Contracts\HttpClientInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Response;

readonly class GuzzleHttpClient implements HttpClientInterface
{
    public function __construct(private Client $client)
    {
    }

    /** @throws GuzzleException */
    public function get(string $url): Response
    {
        return $this->client->get($url);
    }
}
