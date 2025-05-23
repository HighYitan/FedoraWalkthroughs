<?php

namespace Database\Seeders;

use App\Models\Guide;
use App\Models\GuideRating;
use App\Models\ContentGuide;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class GuideSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jsonData = file_get_contents(resource_path('json/guides.json')); //Obtiene el contenido del archivo JSON
        $guides = json_decode($jsonData, true); //Convierte el JSON en un array
        $jsonData = file_get_contents(resource_path('json/content_guides.json')); //Obtiene el contenido del archivo JSON
        $contentGuides = json_decode($jsonData, true); //Convierte el JSON en un array
        $jsonData = file_get_contents(resource_path('json/guide_ratings.json')); //Obtiene el contenido del archivo JSON
        $guideRatings = json_decode($jsonData, true); //Convierte el JSON en un array

        foreach($guides as $guide){
            Guide::create([
                "title"             => $guide["title"],
                "game_release_id"   => $guide["game_release_id"],
                "language_id"       => $guide["language_id"],
                "user_id"           => $guide["user_id"]
            ]);
        }
        foreach($contentGuides as $contentGuide){
            ContentGuide::create([
                "name"      => $contentGuide["name"],
                "content"   => $contentGuide["content"],
                "guide_id"  => $contentGuide["guide_id"]
            ]);
        }
        foreach($guideRatings as $guideRating){
            GuideRating::create([
                "rating"    => $guideRating["rating"],
                "guide_id"  => $guideRating["guide_id"],
                "user_id"   => $guideRating["user_id"]
            ]);
        }
        foreach (Guide::all() as $guide) {
            $guide->updateAverageRating(); // Actualiza la puntuación media de cada guía
        }
    }
}
