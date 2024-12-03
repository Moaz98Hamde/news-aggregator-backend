<?php

namespace App\Services\NewsApi\Responses;

use Illuminate\Support\Facades\Log;

class NYTimesContentNormalizer extends ResponseNormalizer
{
    protected $mappedApiKeys = [
        'source' => 'author',
        'source' => 'source',
        'title' => 'title',
        'abstract' => 'description',
        'url' => 'url',
        'published_date' => 'published_at',
        'image' => 'image'
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
            foreach ($data['results'] as $content) {
                $contentData = array_intersect_key($content ?? [], $this->mappedApiKeys);
                $contentData['image'] = isset($content['multimedia']) && count($content['multimedia']) ?
                $content['multimedia'][0]['url'] : null;
                $contentData['source'] = "nytimes";
                $normalized[] = parent::mappedApiKeys($contentData);
            }
        }else{
            Log::info("Location: ". get_class($this));
            Log::alert("API call error: ", $data);
        }

        return $normalized;
    }
}
