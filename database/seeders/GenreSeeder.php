<?php

namespace Database\Seeders;

use App\Models\Genre;
use App\Models\GenreTranslation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jsonData = file_get_contents(resource_path('json/genres.json')); //Obtiene el contenido del archivo JSON
        $genres = json_decode($jsonData, true); //Convierte el JSON en un array

        foreach($genres as $genre){
            if($genre["language_id"] == 1){
                Genre::create([
                    "slug" => $genre["name"]
                ]);
            }
            GenreTranslation::create([
                "name"          => $genre["name"],
                "description"   => $genre["description"],
                "genre_id"      => $genre["genre_id"],
                "language_id"   => $genre["language_id"]
            ]);
        }
    }
}
