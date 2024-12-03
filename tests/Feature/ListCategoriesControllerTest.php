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

    $this->categories = Category::factory(10)->create();

    $this->responseStructure = [
        'data' => [
            '*' => [
                "id",
                "name",
            ]
        ]
    ];
});

it('lists all categories', function () {
    $response = get('api/categories')
        ->assertOk()
        ->assertJsonStructure($this->responseStructure);
    assertCount(10, $response->json('data'));
});
