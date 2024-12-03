<?php

namespace App\Services\NewsApi\Responses;

use Illuminate\Support\Facades\Log;

class NYTimesSectionsNormalizer extends ResponseNormalizer
{
    protected $mappedApiKeys = [
        'section' => 'name',
        'source' => 'source'
    ];

    /**
     * Normalize the response data from nytimes.com API.
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
        if (isset($data['results']) && is_array($data['results'])) {
            foreach ($data['results'] as $section) {
                $sectionData = array_intersect_key($section ?? [], $this->mappedApiKeys);
                $contentData['source'] = "nytimes";
                $normalized[] = parent::mappedApiKeys($sectionData);
            }
        } else {
            Log::info("Location: " . get_class($this));
            Log::alert("API call error: ", $data);        }

        return $normalized;
    }
}
