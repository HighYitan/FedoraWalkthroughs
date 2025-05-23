<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaveGameRequest;
use App\Http\Resources\GameResource;
use App\Models\Company;
use App\Models\Game;
use App\Models\GameDeveloper;
use App\Models\GamePublisher;
use App\Models\GameTranslation;
use App\Models\Genre;
use App\Models\Language;
use App\Models\Platform;
use App\Models\Region;
use Illuminate\Http\Request;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $games = Game::all();

        return GameResource::collection($games);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SaveGameRequest $request)
    {
        $createdGame = Game::create([ // Crea el videojuego
            'slug'      => $request->nombre_inicial,
            'image'     => $request->imagen,
            'video'     => $request->video,
            'website'   => $request->web
        ]);

        $createdGame->refresh(); // <-- Esto recarga el modelo con los valores de la BD para que incluya destacado con 'N' por defecto y no null en la respuesta

        foreach ($request->traducciones as $traduccion) { // Crea las traducciones del videojuego
            GameTranslation::create([
                'description' => $traduccion['descripcion'],
                'game_id'     => $createdGame->id,
                'language_id' => Language::where('locale', $traduccion['idioma'])->value('id')
            ]);
        }

        $genreIds = [];
        foreach ($request->generos as $genero) {
            $genreId = Genre::where('slug', $genero['nombre_inicial'])->value('id');
            if ($genreId) {
                $genreIds[] = $genreId;
            }
        }
        $createdGame->genres()->sync($genreIds);

        foreach ($request->lanzamientos as $lanzamiento) { // Crea los lanzamientos del videojuego
            $release = $createdGame->gameReleases()->create([
                'name'      => $lanzamiento['nombre'],
                'release_date' => $lanzamiento['lanzamiento'],
                'region_id' => Region::where('slug', $lanzamiento['region'])->value('id')
            ]);

            // Plataformas
            $platformIds = [];
            foreach ($lanzamiento['plataformas'] as $plataforma) {
                $platformId = Platform::where('name', $plataforma['plataforma'])->value('id');
                if ($platformId) {
                    $platformIds[] = $platformId;
                }
            }
            $release->platforms()->sync($platformIds);

            // Desarrolladores
            $developerIds = [];
            foreach ($lanzamiento['desarrolladores'] as $dev) {
                $devId = Company::where('name', $dev['nombre'])->value('id');
                if ($devId) {
                    $developerIds[] = $devId;
                }
            }
            foreach ($developerIds as $devId) {
                GameDeveloper::create([
                    'game_release_id' => $release->id,
                    'company_id'      => $devId,
                ]);
            }
            //$release->gameDevelopers()->sync($developerIds);

            // Distribuidores
            $publisherIds = [];
            foreach ($lanzamiento['distribuidores'] as $publisher) {
                $publisherId = Company::where('name', $publisher['nombre'])->value('id');
                if ($publisherId) {
                    $publisherIds[] = $publisherId;
                }
            }
            foreach ($publisherIds as $publisherId) {
                GamePublisher::create([
                    'game_release_id' => $release->id,
                    'company_id'      => $publisherId,
                ]);
            }
            //$release->gamePublishers()->sync($publisherIds);
        }

        return (new GameResource($createdGame))->additional(['meta' => 'Juego creado correctamente']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Game $game)
    {
        // SELECCIÓ DE LES DADES
        $game->load([
            "gameReleases",
            "gameRatings",
            "gameRatings.user",
        ]);
        return new GameResource($game);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Game $game)
    {
        $game->update([
            'slug'      => $request->nombre_inicial,
            'image'     => $request->imagen,
            'video'     => $request->video,
            'website'   => $request->web
        ]);

        return (new GameResource($game))->additional(['meta' => 'Juego actualizado correctamente']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Game $game)
    {
        foreach ($game->gameReleases as $release) {
            $release->gameDevelopers()->delete();
            $release->gamePublishers()->delete();
            foreach ($release->guides as $guide) {
                $guide->contentGuides()->delete();
            }
            $release->guides()->delete();
            $release->platforms()->detach();
            $release->boards()->delete();
            $release->delete();
        }

        $game->gameRatings()->delete();
        $game->gameTranslations()->delete();
        $game->genres()->detach();
        $game->delete();
        
        return (new GameResource($game))->additional(['meta' => 'Juego eliminado correctamente']);
    }
}
