<?php

namespace App\Jobs;

use App\Models\Article;
use App\Services\NewsApi\NewsApiService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Throwable;

class FetchArticlesApiCallJob implements ShouldQueue
{
    use Queueable;

    protected string $provider;
    protected string $entity;
    protected array $params = [];
    protected string $normalizer;
    protected string $model = Article::class;
    protected string $category;
    /**
     * Create a new job instance.
     */
    public function __construct($provider, $entity, $params, $normalizer, $category)
    {
        $this->provider = $provider;
        $this->entity = $entity;
        $this->params = $params;
        $this->normalizer = $normalizer;
        $this->category = $category;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try{
            $output = NewsApiService::make($this->provider)
            ->setEntity($this->entity)
            ->setQueryParams($this->params)
            ->fetch()
                ->normalizeWith($this->normalizer)
                ->store($this->model, ['category_id' => $this->category],'title');

                dump($output);
        }catch(Throwable $th){
            Log::alert($th->getMessage());
        }

    }
}
