<?php

namespace App\Http\Controllers\Api;

use App\Models\Guide;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\GuideResource;

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
    public function store(Request $request)
    {
        //
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
