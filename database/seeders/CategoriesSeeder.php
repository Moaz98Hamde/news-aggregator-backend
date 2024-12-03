<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Services\NewsApi\NewsApiService;
use App\Services\NewsApi\Responses\NYTimesSectionsNormalizer;
use App\Services\NewsApi\Responses\TheGuardianSectionsNormalizer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['source'=>'newsapiDotOrg','name' => 'business', 'created_at' => now(), 'updated_at' => now()],
            ['source'=>'newsapiDotOrg','name' => 'entertainment', 'created_at' => now(), 'updated_at' => now()],
            ['source'=>'newsapiDotOrg','name' => 'general', 'created_at' => now(), 'updated_at' => now()],
            ['source'=>'newsapiDotOrg','name' => 'health', 'created_at' => now(), 'updated_at' => now()],
            ['source'=>'newsapiDotOrg','name' => 'science', 'created_at' => now(), 'updated_at' => now()],
            ['source'=>'newsapiDotOrg','name' => 'sports', 'created_at' => now(), 'updated_at' => now()],
            ['source'=>'newsapiDotOrg','name' => 'technology', 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('categories')->insert($categories);

        NewsApiService::make('nytimes')
        ->setEntity('content/section-list.json')
        ->setQueryParams(['api-key' => config('services.news-api-providers.nytimes.key')])
        ->fetch()
        ->normalizeWith(NYTimesSectionsNormalizer::class)
        ->store(Category::class, ['source' => 'nytimes']);

        NewsApiService::make('theguardian')
        ->setEntity('sections')
        ->setQueryParams(['api-key' => config('services.news-api-providers.theguardian.key')])
        ->fetch()
        ->normalizeWith(TheGuardianSectionsNormalizer::class)
        ->store(Category::class, ['source' => 'theguardian']);

    }
}
