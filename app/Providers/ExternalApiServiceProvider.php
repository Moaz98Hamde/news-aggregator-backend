<?php

namespace App\Providers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;
use InvalidArgumentException;

class ExternalApiServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Http::macro('newsApiClient', function ($ApiProvider) {
            $service = config("services.news-api-providers.$ApiProvider");
            if (!$service || !isset($service['endpoint'])) {
                throw new InvalidArgumentException("Configuration for service '{$service}' is invalid.");
            }
            return Http::withHeaders($service['headers'] ?? [])->baseUrl($service['endpoint']);
        });
    }
}
