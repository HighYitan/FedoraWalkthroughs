<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaveUserRequest;
use App\Http\Resources\UserResource;
use App\Models\Game;
use App\Models\Guide;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();

        $users->load([
            "role"
        ]);

        return UserResource::collection($users);
    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        // SELECCIÓ DE LES DADES
        $user->load([
            "role",
            "boards",
            "boards.gameRelease",
            "boards.language",
            "boardComments",
            "boardComments.boardCommentImages",
            "gameRatings",
            "gameRatings.game",
            "guides",
            "guideRatings",
            "guideRatings.guide",
            "guideRatings.guide.gameRelease",
        ]);
        return new UserResource($user);
    }
    // HACER SHOW DE COMENTARIOS EN BOARDS DE UN USUARIO (indexBoardComments(User $user))
    public function showUserBoardComments(User $user)
    {
        // SELECCIÓ DE LES DADES
        $user->load([
            "boards.boardComments",
            "boards.boardComments.boardCommentImages",
            "boards.gameRelease",
            "boards.language",
        ]);
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SaveUserRequest $request, User $user)
    {
        $roleId = null;
        if ($request->filled('rol')) {
            $roleId = Role::where('name', $request->rol)->value('id');
        }

        $request = [ // Crea un array con los datos del request mapeados con los campos de la tabla
            'name'      => $request->nombre,
            'email'     => $request->correo,
            'password'  => $request->contraseña,
            'banned'    => $request->baneado,
            'role_id'   => $roleId,
        ];
        $request = array_filter($request, function ($value) { // Elimina los valores nulos del request
            return !is_null($value);
        });
        $user->update($request);

        return (new UserResource($user))->additional(['meta' => 'Usuario modificado correctamente']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // Elimina las relaciones en la tabla pivot student_relative
        $user->boards()->delete();
        $user->boardComments()->delete();
        // Guarda las IDs antes de borrar las puntuaciones
        $gameIds = $user->gameRatings()->pluck('game_id')->unique();
        $guideIds = $user->guideRatings()->pluck('guide_id')->unique();
        $user->gameRatings()->delete();
        $user->guideRatings()->delete();
        foreach ($gameIds as $gameId) {
            $game = Game::find($gameId);
            if ($game) {
                $game->updateAverageRating(); // Actualiza la puntuación media de cada videojuego
            }
        }
        foreach ($guideIds as $guideId) {
            $guide = Guide::find($guideId);
            if ($guide) {
                $guide->updateAverageRating(); // Actualiza la puntuación media de cada guía
            }
        }
        $user->guides()->delete();
        // Revoca todos los tokens del usuario (/register y /login)
        $user->tokens()->delete();
        // Eliminación del usuario
        $user->delete();
        // Formato de la respuesta
        return (new UserResource($user))->additional(['meta' => 'Usuario eliminado correctamente']);
    }
}
