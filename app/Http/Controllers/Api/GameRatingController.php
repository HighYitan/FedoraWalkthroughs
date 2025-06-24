<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaveGameRatingRequest;
use App\Http\Resources\GameResource;
use App\Models\Game;
use App\Models\GameRating;
use App\Models\User;
use Illuminate\Http\Request;

class GameRatingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SaveGameRatingRequest $request)
    {
        $gameId = Game::where('slug', $request->videojuego)->value('id');
        if (!$gameId) {
            return response()->json(['error' => 'Videojuego no encontrado'], 404);
        }
        $userId = User::where('email', $request->usuario)->value('id');
        if (!$userId) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }
        //try{
        $createdGameRating = GameRating::updateOrCreate(
            [
                'game_id' => $gameId, // Unique fields
                'user_id' => $userId  // Unique fields
            ],
            [
                'rating' => $request->puntuacion // Fields to update
            ]
        );
        //}
        /*catch (QueryException $e) {
            // Check for duplicate entry error code
            if ($e->errorInfo[1] == 1062) {
                // Update the existing rating
                GameRating::where('game_id', $gameId)
                    ->where('user_id', $userId)
                    ->update(['rating' => $request->puntuacion]);
            }
        }*/
        
        $game = Game::find($gameId);

        $game->updateAverageRating();
        
        $game->load('gameRatings'); // Carga las puntuaciones del videojuego para que se refleje en la respuesta

        return (new GameResource($game))->additional(['meta' => 'Puntuación creada correctamente']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SaveGameRatingRequest $request, GameRating $gameRating)
    {
        $gameId = Game::where('slug', $request->videojuego)->value('id');
        if (!$gameId) {
            return response()->json(['error' => 'Videojuego no encontrado'], 404);
        }
        $userId = User::where('email', $request->usuario)->value('id');
        if (!$userId) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }

        $gameRating->update([
            'rating'  => $request->puntuacion,
            'game_id' => $gameId,
            'user_id' => $userId
        ]);

        $game = Game::find($gameId);

        $game->updateAverageRating();
        
        $game->load('gameRatings'); // Carga las puntuaciones del videojuego para que se refleje en la respuesta

        return (new GameResource($game))->additional(['meta' => 'Puntuación actualizada correctamente']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GameRating $gameRating)
    {
        $gameId = $gameRating->game_id;
        $gameRating->delete();

        $game = Game::find($gameId);
        $game->updateAverageRating();
        
        $game->load('gameRatings'); // Carga las puntuaciones del videojuego para que se refleje en la respuesta

        return (new GameResource($game))->additional(['meta' => 'Puntuación eliminada correctamente']);
    }
}
