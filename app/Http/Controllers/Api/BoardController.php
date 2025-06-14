<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaveBoardRequest;
use App\Http\Resources\BoardResource;
use App\Models\Board;
use App\Models\Language;
use App\Models\User;
use Illuminate\Http\Request;

class BoardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $boards = Board::all();

        $boards->load([
            "user"
        ]);

        return BoardResource::collection($boards);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SaveBoardRequest $request)
    {
        // Busca el ID del idioma a partir del locale
        $languageId = Language::where('locale', $request->idioma)->value('id');
        if (!$languageId) {
            return response()->json(['error' => 'Idioma no encontrado'], 404);
        }
        $userId = User::where('email', $request->autor)->value('id');
        if (!$userId) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }
        $createdBoard = Board::create([
            'title'             => $request->titulo,
            'description'       => $request->descripcion,
            'game_release_id'   => $request->lanzamiento,
            'language_id'       => $languageId,
            'user_id'           => $userId
        ]);

        return (new BoardResource($createdBoard))->additional(['meta' => 'Tema del foro creado correctamente']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Board $board)
    {
        // SELECCIÓ DE LES DADES
        $board->load([
            "user",
            "boardComments",
            "boardComments.boardCommentImages"
        ]);
        return new BoardResource($board);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SaveBoardRequest $request, Board $board)
    {
        // Busca el ID del idioma a partir del locale
        $languageId = Language::where('locale', $request->idioma)->value('id');
        if (!$languageId) {
            return response()->json(['error' => 'Idioma no encontrado'], 404);
        }
        $userId = User::where('email', $request->autor)->value('id');
        if (!$userId) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }
        $board->update([
            'title'             => $request->titulo,
            'description'       => $request->descripcion,
            'game_release_id'   => $request->lanzamiento,
            'language_id'       => $languageId,
            'user_id'           => $userId
        ]);

        return (new BoardResource($board))->additional(['meta' => 'Tema del foro actualizado correctamente']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Board $board)
    {
        foreach ($board->boardComments as $boardComment) { // Elimina las imágenes asociadas a los comentarios del board
            $boardComment->boardCommentImages()->delete();
        }
        $board->boardComments()->delete(); // Elimina los comentarios asociados al board

        $board->delete();

        return (new BoardResource($board))->additional(['meta' => 'Tema del foro eliminado correctamente']);
    }
}
