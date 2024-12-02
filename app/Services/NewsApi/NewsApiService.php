<?php

namespace App\Services\NewsApi;

use App\Services\NewsApi\Responses\NewsDotOrgHeadlinesNormalizer;
use App\Services\NewsApi\Responses\NewsDotOrgSourcesNormalizer;
use Exception;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

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
     * @param  string  $entity
     * @param  array  $queryParams
     * @return array
     */
    public function fetch(): array
    {
        return $this->hit(Http::newsApiClient($this->provider));
    }

    /**
     * Hit API endpoint with associated entity suffix.
     * @param  \Http\Client\PendingRequest  $httpClient

     * @return array
     */
    public function hit(PendingRequest $httpClient): array
    {
        try {
            // Hit our endpoint with given entity with query params
            $jsonResponse = $httpClient->get($this->entity, $this->queryParams);
            return $this->normalizeResponse($jsonResponse);
        } catch (RequestException $exception) {
            return ['errors' => $exception->getMessage()];
        }
    }

    /**
     * Normalize different providers responses
     * @param  string  $jsonResponse
     * @return array
     */
    public function normalizeResponse(string $jsonResponse)
    {
        return match ([$this->provider, $this->entity]) {
            ['newsapiDotOrg', 'sources'] => NewsDotOrgSourcesNormalizer::make($jsonResponse),
            ['newsapiDotOrg', 'top-headlines'] => NewsDotOrgHeadlinesNormalizer::make($jsonResponse),
            default  => throw new Exception('Mismatch provider or entity')
        };
    }

    public function store() {}
}
