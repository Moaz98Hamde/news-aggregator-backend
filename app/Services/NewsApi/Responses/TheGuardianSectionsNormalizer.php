<?php

namespace App\Services\NewsApi\Responses;

use Illuminate\Support\Facades\Log;

class TheGuardianSectionsNormalizer extends ResponseNormalizer
{
    protected $mappedApiKeys = [
        'webTitle' => 'name',
        'source' => 'source'
    ];

    /**
     * Normalize the response data from theguardian.com API.
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
        if (isset($data['response']['results']) && is_array($data['response']['results'])) {
            foreach ($data['response']['results'] as $section) {
                $sectionData = array_intersect_key($section ?? [], $this->mappedApiKeys);
                $sectionData['source'] = 'theguardian';
                $normalized[] = parent::mappedApiKeys($sectionData);
            }
        } else {
            Log::info("Location: " . get_class($this));
            Log::alert("API call error: ", $data);        }

        return $normalized;
    }
}
