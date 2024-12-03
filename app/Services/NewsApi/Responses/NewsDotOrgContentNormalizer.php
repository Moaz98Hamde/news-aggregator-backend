<?php

namespace App\Services\NewsApi\Responses;

use Illuminate\Support\Facades\Log;

class NewsDotOrgContentNormalizer extends ResponseNormalizer
{
    protected $mappedApiKeys = [
        'author' => 'author',
        'source' => 'source',
        'title' => 'title',
        'description' => 'description',
        'url' => 'url',
        'urlToImage' => 'image',
        'publishedAt' => 'published_at'
    ];

    /**
     * Normalize the response data from newsapi.org API.
     *
     * @param string $jsonResponse
     * @return array
     */
    public function normalize(string $jsonResponse): array
    {
        // Call the parent method to normalize the JSON
        return parent::normalize($jsonResponse);
    }

    public function normalizeStructure(array $data): array
    {
        $normalized = [];

        if (isset($data['articles']) && is_array($data['articles'])) {
            foreach ($data['articles'] as $article) {
                $articleData = array_intersect_key($article ?? [], $this->mappedApiKeys);
                $articleData['source'] = 'news.org';
                $normalized[] = parent::mappedApiKeys($articleData);
            }
        } else {
            Log::info("Location: ",get_class($this));
            Log::alert("API call error: ", $data, );
        }

        return $normalized;
    }
}
