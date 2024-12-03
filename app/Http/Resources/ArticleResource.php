<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "title" => $this->title,
            "source" => $this->source,
            "author" => $this->author,
            "description" => $this->description,
            "url" => $this->url,
            "image" => $this->image,
            "published_at" => $this->published_at?->toDateTimeString(),
            "category" => $this->whenLoaded('category', new CategoryResource($this->category)),
        ];
    }
}
