<?php

namespace App\Console\Commands;

use App\Jobs\FetchArticlesApiCallJob;
use App\Models\Category;
use App\Services\NewsApi\Responses\NewsDotOrgContentNormalizer;
use App\Services\NewsApi\Responses\NYTimesContentNormalizer;
use App\Services\NewsApi\Responses\TheGuardianContentNormalizer;
use Illuminate\Console\Command;

class FetchNewsArticles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch-news-articles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch and update news articles from external API sources';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $newsApiDotOrgCategories = Category::select('id', 'name')->where('source', 'newsapiDotOrg')
            ->get()
            ->toArray();

        $NYTimesCategories = Category::select('id', 'name')->where('source', 'nytimes')
            ->get()
            ->toArray();

        $theGuardianCategories = Category::select('id', 'name')->where('source', 'theguardian')
            ->get()
            ->toArray();

        foreach ($newsApiDotOrgCategories as $category) {
            FetchArticlesApiCallJob::dispatch(
                'newsapiDotOrg',
                'top-headlines',
                ['category' => $category['name']],
                NewsDotOrgContentNormalizer::class,
                $category['id']
            );
        }

        foreach ($theGuardianCategories as $category) {
            FetchArticlesApiCallJob::dispatch(
                'theguardian',
                'search',
                ['sectionName' => $category['name'], 'api-key' => config('services.news-api-providers.theguardian.key')],
                TheGuardianContentNormalizer::class,
                $category['id']
            );
        }

        foreach ($NYTimesCategories as $category) {
            FetchArticlesApiCallJob::dispatch(
                'nytimes',
                'content/all/' . $category['name'],
                ['api-key' => config('services.news-api-providers.nytimes.key')],
                NYTimesContentNormalizer::class,
                $category['id']
            );
        }
    }
}
