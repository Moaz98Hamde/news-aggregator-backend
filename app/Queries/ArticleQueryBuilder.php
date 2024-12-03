<?php

namespace App\Queries;

use Illuminate\Database\Eloquent\Builder;

class ArticleQueryBuilder extends Builder
{
    public function byTitle($value = null)
    {
        if (!$value) {
            return $this;
        }
        return $this->where('title', 'LIKE', "%$value%");
    }

    public function byCategory($value = null)
    {
        if (!$value) {
            return $this;
        }
        return $this->whereHas('category', fn($q) => $q->where('id', $value));
    }

    public function byAuthor($value = null)
    {
        if (!$value) {
            return $this;
        }
        return  $this->where('author', $value);
    }

    public function bySource($value = null)
    {
        if (!$value) {
            return $this;
        }
        return $this->where('source', $value);
    }
}
