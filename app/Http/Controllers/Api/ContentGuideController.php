<?php

namespace App\Http\Controllers\Api;

use App\Models\ContentGuide;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\SaveContentRequest;
use App\Http\Resources\ContentGuideResource;

class ContentGuideController extends Controller
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
    public function store(SaveContentRequest $request)
    {
        $contentGuide = ContentGuide::create([
            'name' => $request->nombre,
            'content' => $request->contenido,
            'guide_id' => $request->guia_id,
        ]);

        return (new ContentGuideResource($contentGuide))->additional(['meta' => 'Sección creada correctamente']);
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
    public function update(SaveContentRequest $request, ContentGuide $contentGuide)
    {
        //dd($contentGuide->id);
        //dd($request->all());
        $contentGuide->update([
            'name' => $request->nombre,
            'content' => $request->contenido,
            'guide_id' => $request->guia_id,
        ]);

        //$contentGuide->refresh(); // Recarga el modelo con los valores actualizados de la BD

        return (new ContentGuideResource($contentGuide))->additional(['meta' => 'Sección actualizada correctamente']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
