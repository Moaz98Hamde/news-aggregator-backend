<?php

namespace App\Http\Controllers;

use App\Http\Resources\ArticleResource;
use App\Models\Article;
use Illuminate\Http\Request;

class ListArticlesController extends Controller
{
    public function __invoke(Request $request)
    {
        $articles = Article::with('category')
        ->byTitle($request->title)
        ->bySource($request->source)
        ->byAuthor($request->author)
        ->byCategory($request->category)
        ->paginate();

        return ArticleResource::collection($articles);
    }
}
