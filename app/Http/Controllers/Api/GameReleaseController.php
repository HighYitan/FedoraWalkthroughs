<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaveGameReleaseRequest;
use App\Http\Resources\GameReleaseResource;
use App\Models\Company;
use App\Models\Game;
use App\Models\GameDeveloper;
use App\Models\GamePublisher;
use App\Models\GameRelease;
use App\Models\Platform;
use App\Models\Region;
use Illuminate\Http\Request;

class GameReleaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $gameReleases = GameRelease::all();

        return GameReleaseResource::collection($gameReleases);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SaveGameReleaseRequest $request)
    {
        $gameId = Game::where('slug', $request->nombre_inicial)->value('id');
        if (!$gameId) {
            return response()->json(['error' => 'Videojuego no encontrado'], 404);
        }
        $regionId = Region::where('slug', $request->region)->value('id');
        if (!$regionId) {
            return response()->json(['error' => 'Región no encontrada'], 404);
        }

        $createdGameRelease = GameRelease::create([
            'name' => $request->nombre,
            'release_date' => $request->lanzamiento,
            'game_id' => $gameId,
            'region_id' => $regionId
        ]);

        foreach ($request->plataformas as $plataforma) {
            $platformId = Platform::where('name', $plataforma)->value('id');
            if (!$platformId) {
                return response()->json(['error' => 'Plataforma no encontrada'], 404);
            }
            $createdGameRelease->platforms()->attach($platformId);
        }

        foreach ($request->desarrolladores as $desarrollador) {
            $developerId = Company::where('name', $desarrollador)->value('id');
            if (!$developerId) {
                return response()->json(['error' => 'Desarrollador no encontrado'], 404);
            }
            GameDeveloper::create([
                'game_release_id' => $createdGameRelease->id,
                'company_id' => $developerId
            ]);
        }

        foreach ($request->distribuidores as $distribuidor) {
            $publisherId = Company::where('name', $distribuidor)->value('id');
            if (!$publisherId) {
                return response()->json(['error' => 'Distribuidor no encontrado'], 404);
            }
            GamePublisher::create([
                'game_release_id' => $createdGameRelease->id,
                'company_id' => $publisherId
            ]);
        }

        $createdGameRelease->load([
            'game',
            'platforms',
            'gameDevelopers.company',
            'gamePublishers.company'
        ]);

        return (new GameReleaseResource($createdGameRelease))->additional(['meta' => 'Lanzamiento del videojuego creado correctamente']);
    }

    /**
     * Display the specified resource.
     */
    public function show(GameRelease $gameRelease)
    {
        // Load related data
        $gameRelease->load([
            'game',
            'platforms',
            'gameDevelopers.company',
            'gamePublishers.company',
            'guides',
            'boards'
        ]);

        return new GameReleaseResource($gameRelease);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SaveGameReleaseRequest $request, GameRelease $gameRelease)
    {
        $gameId = Game::where('slug', $request->nombre_inicial)->value('id');
        if (!$gameId) {
            return response()->json(['error' => 'Videojuego no encontrado'], 404);
        }
        $regionId = Region::where('slug', $request->region)->value('id');
        if (!$regionId) {
            return response()->json(['error' => 'Región no encontrada'], 404);
        }

        $gameRelease->update([
            'name' => $request->nombre,
            'release_date' => $request->lanzamiento,
            'game_id' => $gameId,
            'region_id' => $regionId
        ]);

        // Update platforms
        $platformIds = Platform::whereIn('name', $request->plataformas)->pluck('id');
        $gameRelease->platforms()->sync($platformIds);

        // Update developers
        $developerIds = Company::whereIn('name', $request->desarrolladores)->pluck('id');
        $gameRelease->gameDevelopers()->delete();
        foreach ($developerIds as $developerId) {
            GameDeveloper::create([
                'game_release_id' => $gameRelease->id,
                'company_id' => $developerId
            ]);
        }

        // Update publishers
        $publisherIds = Company::whereIn('name', $request->distribuidores)->pluck('id');
        $gameRelease->gamePublishers()->delete();
        foreach ($publisherIds as $publisherId) {
            GamePublisher::create([
                'game_release_id' => $gameRelease->id,
                'company_id' => $publisherId
            ]);
        }

        $gameRelease->load([
            'game',
            'platforms',
            'gameDevelopers.company',
            'gamePublishers.company'
        ]);

        return (new GameReleaseResource($gameRelease))->additional(['meta' => 'Lanzamiento del videojuego actualizado correctamente']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GameRelease $gameRelease)
    {
        $gameRelease->load([
            'game',
            'platforms',
            'gameDevelopers.company',
            'gamePublishers.company',
            'guides',
            'boards'
        ]);

        // Eliminar las relaciones de plataformas, desarrolladores y distribuidores
        $gameRelease->platforms()->detach();
        $gameRelease->gameDevelopers()->delete();
        $gameRelease->gamePublishers()->delete();
        $gameRelease->guides()->delete(); // Eliminar las guías asociadas
        $gameRelease->boards()->delete(); // Eliminar los boards asociados

        // Eliminar el lanzamiento del videojuego
        $gameRelease->delete();

        return (new GameReleaseResource($gameRelease))->additional(['meta' => 'Lanzamiento del videojuego eliminado correctamente']);
    }
}
