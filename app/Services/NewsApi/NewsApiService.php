<?php

namespace App\Services\NewsApi;

use Carbon\Carbon;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class NewsApiService
{
    /**
     * Holds API provider.
     *
     * @var string
     */
    protected string $provider;

    /**
     * Holds API entity.
     *
     * @var string
     */
    protected string $entity;


    protected string $jsonResponse;


    protected array $normalizedResponse;

    /**
     * Holds API query params.
     *
     * @var array
     */
    protected array $queryParams = [];

    public function __construct(string $provider)
    {
        $this->provider = $provider;
    }

    /**
     * Create a new NewsApiService instance.
     *
     * @param  string  $provider
     * @return NewsApiService
     */
    public static function make(string $provider): NewsApiService
    {
        return new self($provider);
    }

    /**
     * Initialize entity
     * @param  string  $entity
     * @return object
     */
    public function setEntity(string $entity): object
    {
        $this->entity = $entity;
        return $this;
    }

    /**
     * Initialize query parameters
     * @param  array  $params
     * @return object
     */
    public function setQueryParams(array $queryParams = []): object
    {
        $this->queryParams = $queryParams;
        return $this;
    }

    /**
     * Hit API endpoint through given Entity & query params
     * @return NewsApiService
     */
    public function fetch(): NewsApiService
    {
        return $this->hit(Http::newsApiClient($this->provider));
    }

    /**
     * Hit API endpoint with associated entity suffix.
     * @param  \Http\Client\PendingRequest  $httpClient

     * @return NewsApiService
     */
    public function hit(PendingRequest $httpClient): NewsApiService
    {
        try {
            // Hit our endpoint with given entity with query params
            $this->jsonResponse = $httpClient->get($this->entity, $this->queryParams);
            return $this;
        } catch (RequestException $exception) {
            Log::alert($exception->getMessage());
            return ['errors' => $exception->getMessage()];
        }
    }

    public function normalizeWith(string $normalizer)
    {
        $this->normalizedResponse = $normalizer::make($this->jsonResponse);
        return $this;
    }


    public function store(string $model, array $extra = [], string $unique = null)
    {
        if ($this->normalizedResponse) {
            foreach ($this->normalizedResponse as $item) {
                $item['published_at'] = Carbon::parse($item['published_at']);
                if($unique){
                    $model::firstOrCreate(
                        [$unique => $item[$unique]],
                        array_merge($item, $extra)
                    );
                }else{
                    $model::create(array_merge($item, $extra));
                }
            }
            return true;
        }
        return false;
    }
}
