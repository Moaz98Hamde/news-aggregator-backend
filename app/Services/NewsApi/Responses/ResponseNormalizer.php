<?php

namespace App\Services\NewsApi\Responses;

use App\Interfaces\ResponseNormalizerInterface;

abstract class ResponseNormalizer implements ResponseNormalizerInterface
{
    protected $mappedApiKeys = [];
    protected $jsonResponse;

    public function __construct(string $jsonResponse)
    {
        $this->jsonResponse = $jsonResponse;
    }

    /**
     * Create a new NewsApiService instance.
     *
     * @param  string  $provider
     * @return NewsApiService
     */
    public static function make(string $jsonResponse): array
    {
        return (new static($jsonResponse))->normalize($jsonResponse);
    }

    public function normalize(string $jsonResponse): array
    {
        $data = json_decode($jsonResponse, true);
        return $this->normalizeStructure($data);
    }

    public function mappedApiKeys(array $dataToMap)
    {
        $mappedData = [];

        foreach ($dataToMap as $key => $value) {
            if (isset($this->mappedApiKeys[$key])) {
                $mappedData[$this->mappedApiKeys[$key]] = $value;
            }
        }

        return $mappedData;
    }


    abstract public function normalizeStructure(array $data): array;
}
