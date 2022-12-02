<?php

namespace Database\Factories;

use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Article>
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
            "name" => ucwords(fake()->words(3, true)),
            "description" => ucfirst(fake()->realText(2048)),
            "category" => ucfirst(fake()->words(3, true)),
            "price" => fake()->numerify('###.##'),
            "currency" => fake()->currencyCode()
        ];
    }
}
