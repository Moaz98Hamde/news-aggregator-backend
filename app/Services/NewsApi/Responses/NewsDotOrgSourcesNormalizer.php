<?php

namespace App\Services\NewsApi\Responses;

class NewsDotOrgSourcesNormalizer extends ResponseNormalizer
{
    protected $mappedApiKeys = [
        'name' => 'name',
        'category' => 'category',
        'country' => 'country'
    ];

    /**
     * Normalize the response data from newsapi.org API.
     *
     * @param string $json
     * @return array
     */
    public function normalize(string $json): array
    {
        return parent::normalize($json);
    }

    public function normalizeStructure(array $data): array
    {
        $normalized = [];

        if (isset($data['sources']) && is_array($data['sources'])) {
            foreach ($data['sources'] as $source) {
                $sourceData = array_intersect_key($source ?? [], $this->mappedApiKeys);
                $normalized[] = parent::mappedApiKeys($sourceData);
            }
        }

        return $normalized;
    }
}
