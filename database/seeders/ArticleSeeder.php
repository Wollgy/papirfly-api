<?php

namespace Database\Seeders;

use Database\Factories\ArticleFactory;
use Illuminate\Database\Seeder;
use App\Models\Article;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [[
            "article_id" => 1,
            "name" => "Branded Memory Stick",
            "description" => "Branded 16 GB memory stick",
            "category" => "USB flash drive",
            "price" => 17.89,
            "currency" => "NOK"
        ]];

        foreach ($items as $item) {
            Article::updateOrCreate([
                "article_id" => $item["article_id"],
                "name" => $item["name"],
                "description" => $item["description"],
                "category" => $item["category"],
                "price" => $item["price"],
                "currency" => $item["currency"],
            ]);
        }

        Article::factory()
            ->count(10)
            ->create();
    }
}
