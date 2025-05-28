<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaveGuideRequest;
use App\Http\Resources\GuideResource;
use App\Models\ContentGuide;
use App\Models\Guide;
use App\Models\Language;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GuideController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $guides = Guide::all();

        return GuideResource::collection($guides);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SaveGuideRequest $request)
    {
        $languageId = Language::where('locale', $request->idioma)->value('id');
        if (!$languageId) {
            return response()->json(['error' => 'Idioma no encontrado'], 404);
        }
        $userId = User::where('email', $request->correo)->value('id');
        if (!$userId) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }

        $createdGuide = Guide::create([
            'title'             => $request->titulo,
            'game_release_id'   => $request->lanzamiento_id,
            'language_id'       => $languageId,
            'user_id'           => $userId,
        ]);

        foreach ($request->contenidos as $contenido) { // Crea el contenido de la guía (Secciones (name) + Párrafos (content))
            ContentGuide::create([
                'name'      => $contenido['nombre'],
                'content'   => $contenido['contenido'],
                'guide_id'  => $createdGuide->id
            ]);
        }

        return (new GuideResource($createdGuide))->additional(['meta' => 'Guía creada correctamente']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Guide $guide)
    {
        // Cargar las relaciones necesarias para la guía
        $guide->load([
            "contentGuides",
            "user",
            "gameRelease"
        ]);

        return new GuideResource($guide);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SaveGuideRequest $request, Guide $guide)
    {
        $validator = Validator::make($request->all(), [
            'titulo'            => 'nullable|string|min:6|max:100',
            'aprobado'          => 'nullable|in:0,1',
            'lanzamiento_id'    => 'nullable|integer|exists:game_releases,id',
            'idioma'            => 'nullable|string|exists:languages,locale',
            'correo'            => 'nullable|string|email|min:6|max:100|exists:users,email|regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/',
        ], [
            'titulo.required'       => "Título es obligatorio",
            'titulo.string'         => "Título ha de ser una cadena de texto",
            'titulo.min'            => "Mínimo 6 car",
            'titulo.max'            => "Máximo 100 car",
            'aprobado.in'           => "Aprobado ha de ser 0 o 1",
            'lanzamiento_id.integer'=> "Lanzamiento ha de ser un número entero",
            'lanzamiento_id.exists' => "Lanzamiento no existe",
            'idioma.string'         => "Idioma ha de ser una cadena de texto",
            'idioma.exists'         => "Idioma no existe",
            'correo.required'       => "Correo es obligatorio",
            'correo.string'         => "Correo ha de ser una cadena de texto",
            'correo.email'          => "Correo ha de ser un correo válido",
            'correo.min'            => "Mínimo 6 car para el correo",
            'correo.max'            => "Máximo 100 car para el correo",
            'correo.regex'          => "Correo ha de ser un correo válido"
        ]);

        $languageId = Language::where('locale', $request->idioma)->value('id');
        if (!$languageId) {
            return response()->json(['error' => 'Idioma no encontrado'], 404);
        }
        $userId = User::where('email', $request->correo)->value('id');
        if (!$userId) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }

        $guide->update([
            'title'             => $request->titulo,
            'game_release_id'   => $request->lanzamiento_id,
            'language_id'       => $languageId,
            'user_id'           => $userId,
            'is_approved'       => $request->aprobado 
        ]);

        return (new GuideResource($guide))->additional(['meta' => 'Guía actualizada correctamente']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Guide $guide)
    {
        foreach ($guide->contentGuides as $contentGuide) {
            $contentGuide->delete();
        }
        foreach ($guide->guideRatings as $guideRating) {
            $guideRating->delete();
        }

        $guide->delete();

        return (new GuideResource($guide))->additional(['meta' => 'Guía eliminada correctamente']);
    }
}
