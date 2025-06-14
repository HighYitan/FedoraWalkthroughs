<?php

namespace App\Http\Controllers;

use App\Models\ContentGuide;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;

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
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $guideId = $request->input('guia_id');

        return view('content.create', ['guia' => $guideId]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $token = session('api_token');
        $response = Http::withToken($token)->withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ])->post(url('/api/content'), $data);

        if ($response->failed()) {
            $apiErrors = $response->json('errors') ?? ['api' => ['Error al crear la sección']];
            return redirect()
                ->back()
                ->withInput()
                ->withErrors($apiErrors);
        }

        return redirect()->route('guide.show', ['guide' => $data['guia_id']]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, ContentGuide $contentGuide)
    {
        $token = session('api_token');
        $guideId = $request->input('guia_id');
        // Convertir el modelo a array
        $contentGuideArray = $contentGuide->toArray();
        // Encriptar el id y reemplazarlo en el array
        $contentGuideArray['id'] = Crypt::encryptString($contentGuide->id);

        $response = Http::withToken($token)->get(url('/api/guide/' . $guideId));
        $guide = $response->json('data');

        return view('content.edit', ['contentGuide' => $contentGuideArray, 'guide' => $guide]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ContentGuide $contentGuide)
    {
        $data = $request->all();

        $token = session('api_token');
        $encryptedId = Crypt::encryptString($contentGuide->id);
        $response = Http::withToken($token)->withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ])->put(url('/api/content/' . $encryptedId), $data);

        if ($response->failed()) {
            $apiErrors = $response->json('errors') ?? ['api' => ['Error al actualizar la sección']];
            return redirect()
                ->back()
                ->withInput()
                ->withErrors($apiErrors);
        }

        return redirect()->route('guide.show', ['guide' => $data['guia_id']]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ContentGuide $contentGuide)
    {
        $token = session('api_token');
        $encryptedId = Crypt::encryptString($contentGuide->id);
        $response = Http::withToken($token)->delete(url('/api/content/' . $encryptedId));
        // Convertir el modelo a array
        $contentGuideArray = $contentGuide->toArray();
        // Encriptar el id y reemplazarlo en el array
        $contentGuideArray['guide_id'] = Crypt::encryptString($contentGuide->guide_id);

        if ($response->failed()) {
            $apiErrors = $response->json('errors') ?? ['api' => ['Error al eliminar la sección']];
            return redirect()
                ->back()
                ->withErrors($apiErrors);
        }

        return redirect()->route('guide.show', ['guide' => $contentGuideArray['guide_id']]);
    }
}
