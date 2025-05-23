<?php

namespace Database\Seeders;

use App\Models\Game;
use App\Models\GameDeveloper;
use App\Models\GamePublisher;
use App\Models\GameRating;
use App\Models\GameRelease;
use App\Models\GameTranslation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jsonData = file_get_contents(resource_path('json/games.json')); //Obtiene el contenido del archivo JSON
        $games = json_decode($jsonData, true); //Convierte el JSON en un array
        $jsonData = file_get_contents(resource_path('json/game_translations.json')); //Obtiene el contenido del archivo JSON
        $gameTranslations = json_decode($jsonData, true); //Convierte el JSON en un array
        $jsonData = file_get_contents(resource_path('json/game_genre.json')); //Obtiene el contenido del archivo JSON
        $gameGenres = json_decode($jsonData, true); //Convierte el JSON en un array
        $jsonData = file_get_contents(resource_path('json/game_platform.json')); //Obtiene el contenido del archivo JSON
        $gamePlatforms = json_decode($jsonData, true); //Convierte el JSON en un array
        $jsonData = file_get_contents(resource_path('json/game_developer.json')); //Obtiene el contenido del archivo JSON
        $gameDevelopers = json_decode($jsonData, true); //Convierte el JSON en un array
        $jsonData = file_get_contents(resource_path('json/game_publisher.json')); //Obtiene el contenido del archivo JSON
        $gamePublishers = json_decode($jsonData, true); //Convierte el JSON en un array
        $jsonData = file_get_contents(resource_path('json/game_rating.json')); //Obtiene el contenido del archivo JSON
        $gameRatings = json_decode($jsonData, true); //Convierte el JSON en un array

        foreach($games as $game){
            if($game["region_id"] == 2){
                $createdGame = Game::create([
                    "slug"          => $game["name"],
                    "image"         => $game["image"],
                    "video"         => $game["video"],
                    "website"       => $game["website"]
                ]);
            }
            GameRelease::create([
                "name"          => $game["name"],
                "release_date"  => $game["release_date"],
                "game_id"       => $createdGame->id,
                "region_id"     => $game["region_id"]
            ]);
        }
        foreach($gameTranslations as $gameTranslation){
            GameTranslation::create([
                "description"   => $gameTranslation["description"],
                "game_id"       => $gameTranslation["game_id"],
                "language_id"   => $gameTranslation["language_id"]
            ]);
        }
        foreach($gameGenres as $gameGenre){
            $game = Game::find($gameGenre["game_id"]);
            if ($game) {
                $game->genres()->attach($gameGenre["genre_id"]);
            }
        }
        foreach($gamePlatforms as $gamePlatform){
            $gameRelease = GameRelease::find($gamePlatform["game_release_id"]);
            if ($gameRelease) {
                $gameRelease->platforms()->attach($gamePlatform["platform_id"]);
            }
        }
        foreach($gameDevelopers as $gameDeveloper){
            GameDeveloper::create([
                "company_id"        => $gameDeveloper["company_id"],
                "game_release_id"   => $gameDeveloper["game_release_id"]
            ]);
        }
        foreach($gamePublishers as $gamePublisher){
            GamePublisher::create([
                "company_id"        => $gamePublisher["company_id"],
                "game_release_id"   => $gamePublisher["game_release_id"]
            ]);
        }
        foreach($gameRatings as $gameRating){
            GameRating::create([
                "rating"    => $gameRating["rating"],
                "game_id"   => $gameRating["game_id"],
                "user_id"   => $gameRating["user_id"],
            ]);
        }
        foreach (Game::all() as $game) {
            $game->updateAverageRating(); // Actualiza la puntuación media de cada videojuego
        }
    }
}
