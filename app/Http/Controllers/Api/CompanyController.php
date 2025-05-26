<?php

namespace App\Http\Controllers\Api;

use App\Models\Company;
use App\Models\Language;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CompanyResource;
use App\Http\Requests\SaveCompanyRequest;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $companies = Company::all();

        return CompanyResource::collection($companies);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SaveCompanyRequest $request)
    {
        $languageId = Language::where('locale', $request->pais)->value('id');
        if (!$languageId) {
            return response()->json(['error' => 'País no encontrado'], 404);
        }

        $createdCompany = Company::create([
            'name'              => $request->nombre,
            'foundation_year'   => $request->fundacion,
            'country_id'        => $languageId,
            'website'           => $request->web,
            'image'             => $request->imagen,
        ]);

        return (new CompanyResource($createdCompany))->additional(['meta' => 'Compañía creada correctamente']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company)
    {
        $company->load([
            "gameDevelopers.gameRelease",
            "gamePublishers.gameRelease",
        ]);
        return new CompanyResource($company);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SaveCompanyRequest $request, Company $company)
    {
        $languageId = Language::where('locale', $request->pais)->value('id');
        if (!$languageId) {
            return response()->json(['error' => 'País no encontrado'], 404);
        }

        $company->update([
            'name'              => $request->nombre,
            'foundation_year'   => $request->fundacion,
            'country_id'        => $languageId,
            'website'           => $request->web,
            'image'             => $request->imagen,
        ]);

        return (new CompanyResource($company))->additional(['meta' => 'Compañía actualizada correctamente']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        $company->load([
            'gameDevelopers',
            'gamePublishers',
        ]);

        // Eliminar las relaciones de desarrolladores y distribuidores
        foreach ($company->gameDevelopers as $developer) {
            $developer->delete();
        }
        foreach ($company->gamePublishers as $publisher) {
            $publisher->delete();
        }

        $company->platforms()->delete(); // Borra las plataformas asociadas a la compañía
        
        // Eliminar la compañía
        $company->delete();

        return (new CompanyResource($company))->additional(['meta' => 'Compañía eliminada correctamente']);
    }
}
