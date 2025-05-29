<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaveGuideRatingRequest;
use App\Http\Resources\GuideResource;
use App\Models\Guide;
use App\Models\GuideRating;
use App\Models\User;
use Illuminate\Http\Request;

class GuideRatingController extends Controller
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
    public function store(SaveGuideRatingRequest $request)
    {
        $userId = User::where('email', $request->usuario)->value('id');
        if (!$userId) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }

        $createdGuideRating = GuideRating::create([
            'rating'  => $request->puntuacion,
            'guide_id' => $request->guia,
            'user_id' => $userId
        ]);
        
        $guide = Guide::find($request->guia);

        $guide->updateAverageRating();
        
        $guide->load('guideRatings'); // Carga las puntuaciones de la guía para que se refleje en la respuesta

        return (new GuideResource($guide))->additional(['meta' => 'Puntuación creada correctamente']);
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
    public function update(SaveGuideRatingRequest $request, GuideRating $guideRating)
    {
        $userId = User::where('email', $request->usuario)->value('id');
        if (!$userId) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }

        $guideRating->update([
            'rating' => $request->puntuacion,
            'user_id' => $userId
        ]);

        $guide = Guide::find($guideRating->guide_id);

        $guide->updateAverageRating();
        
        $guide->load('guideRatings'); // Carga las puntuaciones de la guía para que se refleje en la respuesta

        return (new GuideResource($guide))->additional(['meta' => 'Puntuación actualizada correctamente']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GuideRating $guideRating)
    {
        $guide = Guide::find($guideRating->guide_id);
        
        $guideRating->delete();

        $guide->updateAverageRating();
        
        $guide->load('guideRatings'); // Carga las puntuaciones de la guía para que se refleje en la respuesta

        return (new GuideResource($guide))->additional(['meta' => 'Puntuación eliminada correctamente']);
    }
}
