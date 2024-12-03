<?php

namespace App\Models;

use App\Queries\ArticleQueryBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'source',
        'author',
        'description',
        'url',
        'image',
        'published_at',
        'category_id',
    ];

    protected $casts = ['published_at' => 'datetime'];

    public function newEloquentBuilder($query): ArticleQueryBuilder
    {
        return new ArticleQueryBuilder($query);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }
}
