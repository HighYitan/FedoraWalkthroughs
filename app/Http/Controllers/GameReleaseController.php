<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\GameRelease;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;

class GameReleaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $token = session('api_token');
        $response = Http::withToken($token)->get(url('/api/gameRelease'));

        $gameReleases = $response->json('data');

        return view('gameRelease.index', ['gameReleases' => $gameReleases]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $token = session('api_token');

        $response = Http::withToken($token)->get(url('/api/game'));
        $games = $response->json('data');
        $response = Http::withToken($token)->get(url('/api/region'));
        $regions = $response->json('data');
        $response = Http::withToken($token)->get(url('/api/platform'));
        $platforms = $response->json('data');
        $response = Http::withToken($token)->get(url('/api/company'));
        $companies = $response->json('data');

        return view('gameRelease.create', ['games' => $games, 'regions' => $regions, 'platforms' => $platforms, 'companies' => $companies]);
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
        ])->post(url('/api/gameRelease'), $data);

        if ($response->failed()) {
            $apiErrors = $response->json('errors') ?? ['api' => ['Error al añadir el lanzamiento del videojuego']];
            return redirect()
                ->back()
                ->withInput()
                ->withErrors($apiErrors);
        }
        
        return redirect()->route('gameRelease.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(GameRelease $gameRelease)
    {
        $token = session('api_token');

        $encryptedId = Crypt::encryptString($gameRelease->id);
        $response = Http::withToken($token)->get(url('/api/gameRelease/' . $encryptedId));

        $gameRelease = $response->json('data');

        return view('gameRelease.show', ['gameRelease' => $gameRelease]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GameRelease $gameRelease)
    {
        $token = session('api_token'); // Get the token from the session
        $encryptedId = Crypt::encryptString($gameRelease->id);
        $response = Http::withToken($token)->get(url('/api/gameRelease/' . $encryptedId));
        $gameRelease = $response->json('data');

        $response = Http::withToken($token)->get(url('/api/game'));
        $games = $response->json('data');
        $response = Http::withToken($token)->get(url('/api/region'));
        $regions = $response->json('data');
        $response = Http::withToken($token)->get(url('/api/platform'));
        $platforms = $response->json('data');
        $response = Http::withToken($token)->get(url('/api/company'));
        $companies = $response->json('data');

        return view('gameRelease.edit', ['gameRelease' => $gameRelease, 'games' => $games, 'regions' => $regions, 'platforms' => $platforms, 'companies' => $companies]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, GameRelease $gameRelease)
    {
        $data = $request->all();
        $encryptedId = Crypt::encryptString($gameRelease->id);
        
        $token = session('api_token');
        $response = Http::withToken($token)->withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ])->put(url('/api/gameRelease/' . $encryptedId), $data);

        if ($response->failed()) {
            $apiErrors = $response->json('errors') ?? ['api' => ['Error al actualizar el lanzamiento del videojuego']];
            return redirect()
                ->back()
                ->withInput()
                ->withErrors($apiErrors);
        }
        
        return redirect()->route('gameRelease.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GameRelease $gameRelease)
    {
        $encryptedId = Crypt::encryptString($gameRelease->id);
        
        $token = session('api_token');
        $response = Http::withToken($token)->delete(url('/api/gameRelease/' . $encryptedId));

        if ($response->failed()) {
            $apiErrors = $response->json('errors') ?? ['api' => ['Error al eliminar el lanzamiento del videojuego']];
            return redirect()
                ->back()
                ->withErrors($apiErrors);
        }
        
        return redirect()->route('gameRelease.index');
    }
}
