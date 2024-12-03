<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Support\Facades\Schema;
use function Pest\Laravel\get;
use function PHPUnit\Framework\assertCount;

uses(RefreshDatabase::class);
beforeEach(function () {
    Schema::disableForeignKeyConstraints();

    $this->articles = Article::factory(10)->forCategory()->create();

    $this->responseStructure = [
        'data' => [
            '*' => [
                "id",
                "title",
                "source",
                "author",
                "description",
                "url",
                "image",
                "published_at",
                "category",
            ]
        ]
    ];
});

it('lists all articles', function () {
    $response = get('api/articles')
        ->assertOk()
        ->assertJsonStructure($this->responseStructure);
    assertCount(10, $response->json('data'));
});

it('lists articles filtered by author', function () {
    $name = $this->articles->first()->author;

    $response = get('api/articles?author=' . $name)
        ->assertOk()
        ->assertJsonStructure($this->responseStructure);
    assertCount(1, $response->json('data'));
});

it('lists articles filtered by category', function () {
    $category = Category::factory()->hasArticles(5)->create();

    $response = get('api/articles?category=' . $category->id)
        ->assertOk()
        ->assertJsonStructure($this->responseStructure);
    assertCount(5, $response->json('data'));
});

it('lists articles filtered by source', function () {
    $source = $this->articles->first()->source;

    $response = get('api/articles?source=' . $source)
        ->assertOk()
        ->assertJsonStructure($this->responseStructure);
    assertCount(1, $response->json('data'));
});

it('lists articles filtered by title', function () {
    $title = 'Title for test purpose';
    $this->articles->first()->update(['title' => $title]);

    $response = get('api/articles?title=' . $title)
        ->assertOk()
        ->assertJsonStructure($this->responseStructure);
    assertCount(1, $response->json('data'));
});
