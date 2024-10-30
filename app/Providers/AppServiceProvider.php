<?php

declare(strict_types=1);

namespace App\Providers;

use App\Clients\Contracts\HttpClientInterface;
use App\Clients\GuzzleHttpClient;
use App\Repositories\Contracts\JobRepositoryInterface;
use App\Repositories\RedisJobRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(HttpClientInterface::class, GuzzleHttpClient::class);
        $this->app->bind(JobRepositoryInterface::class, RedisJobRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
