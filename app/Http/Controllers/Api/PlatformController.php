<?php

namespace App\Http\Controllers\Api;

use App\Models\Company;
use App\Models\Platform;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PlatformResource;
use App\Http\Requests\SavePlatformRequest;

class PlatformController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $platforms = Platform::all();

        return PlatformResource::collection($platforms);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SavePlatformRequest $request)
    {
        $companyId = Company::where('name', $request->desarrollador)->value('id');
        if (!$companyId) {
            return response()->json(['error' => 'Compañía no encontrada'], 404);
        }
        $createdPlatform = Platform::create([
            'name'          => $request->nombre,
            'release_year'  => $request->lanzamiento,
            'image'         => $request->imagen,
            'company_id'    => $companyId
        ]);

        return (new PlatformResource($createdPlatform))->additional(['meta' => 'Plataforma creada correctamente']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Platform $platform)
    {
        $platform->load([
            'gameReleases'
        ]);

        return new PlatformResource($platform);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SavePlatformRequest $request, Platform $platform)
    {
        $companyId = Company::where('name', $request->desarrollador)->value('id');
        if (!$companyId) {
            return response()->json(['error' => 'Compañía no encontrada'], 404);
        }
        $platform->update([
            'name'          => $request->nombre,
            'release_year'  => $request->lanzamiento,
            'image'         => $request->imagen,
            'company_id'    => $companyId
        ]);
        return (new PlatformResource($platform))->additional(['meta' => 'Plataforma actualizada correctamente']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Platform $platform)
    {
        $platform->gameReleases()->detach(); // Desvincula las plataformas de los lanzamientos

        $platform->delete();
        return (new PlatformResource($platform))->additional(['meta' => 'Platforma eliminada correctamente']);
    }
}
