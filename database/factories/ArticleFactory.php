<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->title(),
            'source' => fake()->name(),
            'author' => fake()->name(),
            'description' => fake()->paragraph(),
            'url' => fake()->url(),
            'image' => fake()->url(),
            'published_at' => now(),
        ];
    }
}
