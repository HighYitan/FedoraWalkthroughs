<?php

namespace Database\Seeders;

use App\Models\News;
use App\Models\NewsLanguage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jsonData = file_get_contents(resource_path('json/news.json')); //Obtiene el contenido del archivo JSON
        $news = json_decode($jsonData, true); //Convierte el JSON en un array

        foreach($news as $newsItem){
            if($newsItem["language_id"] == 1){
                News::create([
                    "slug" => $newsItem["title"]
                ]);
            }
            NewsLanguage::create([
                "title" => $newsItem["title"],
                "content" => $newsItem["content"],
                "image" => $newsItem["image"],
                "news_id" => $newsItem["news_id"],
                "language_id" => $newsItem["language_id"]
            ]);
        }
    }
}
