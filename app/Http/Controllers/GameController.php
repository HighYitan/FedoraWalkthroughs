<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $token = session('api_token'); // Token de la sesión
        $response = Http::withToken($token)->get(url('/api/game'));
        // Recibe la respuesta de la API y la convierte a un array
        $games = $response->json('data');

        return view('game.index', ['games' => $games]); // compact creates an array like ['games' => $games]
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $token = session('api_token');

        $response = Http::withToken($token)->get(url('/api/genre'));
        $genres = $response->json('data');
        $response = Http::withToken($token)->get(url('/api/region'));
        $regions = $response->json('data');
        $response = Http::withToken($token)->get(url('/api/platform'));
        $platforms = $response->json('data');
        $response = Http::withToken($token)->get(url('/api/company'));
        $companies = $response->json('data');

        return view('game.create', ['genres' => $genres, 'regions' => $regions, 'platforms' => $platforms, 'companies' => $companies]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $descripcionES = $request->input('descripcionES');
        $descripcionCA = $request->input('descripcionCA');
        $descripcionEN = $request->input('descripcionEN');
        $traducciones = [
            [
                'descripcion' => $descripcionES,
                'idioma' => 'ES'
            ],
            [
                'descripcion' => $descripcionCA,
                'idioma' => 'CA'
            ],
            [
                'descripcion' => $descripcionEN,
                'idioma' => 'EN'
            ]
        ];
        $data = $request->all();
        $data['traducciones'] = $traducciones;
        
        $token = session('api_token'); // Get the token from the session
        $response = Http::withToken($token)->withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ])->post(url('/api/game'), $data);

        if ($response->failed()) {
            $apiErrors = $response->json('errors') ?? ['api' => ['Error al añadir el videojuego']];
            return redirect()
                ->back()
                ->withInput()
                ->withErrors($apiErrors);
        }
        
        return redirect()->route('game.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Game $game)
    {
        $token = session('api_token'); // Get the token from the session
        $response = Http::withToken($token)->get(url('/api/game/' . $game->slug));

        $game = $response->json('data');

        return view('game.show', ['game' => $game]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Game $game)
    {
        $token = session('api_token'); // Get the token from the session
        $response = Http::withToken($token)->get(url('/api/game/' . $game->slug));
        $game = $response->json('data');

        $response = Http::withToken($token)->get(url('/api/genre'));
        $genres = $response->json('data');
        $response = Http::withToken($token)->get(url('/api/region'));
        $regions = $response->json('data');
        $response = Http::withToken($token)->get(url('/api/platform'));
        $platforms = $response->json('data');
        $response = Http::withToken($token)->get(url('/api/company'));
        $companies = $response->json('data');

        return view('game.edit', ['game' => $game, 'genres' => $genres, 'regions' => $regions, 'platforms' => $platforms, 'companies' => $companies]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Game $game)
    {
        $descripcionES = $request->input('descripcionES');
        $descripcionCA = $request->input('descripcionCA');
        $descripcionEN = $request->input('descripcionEN');
        $traducciones = [
            [
                'descripcion' => $descripcionES,
                'idioma' => 'ES'
            ],
            [
                'descripcion' => $descripcionCA,
                'idioma' => 'CA'
            ],
            [
                'descripcion' => $descripcionEN,
                'idioma' => 'EN'
            ]
        ];
        $data = $request->all();
        $data['traducciones'] = $traducciones;

        $token = session('api_token'); // Get the token from the session
        $response = Http::withToken($token)->withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ])->put(url('/api/game/' . $game->slug), $data);

        if ($response->failed()) {
            $apiErrors = $response->json('errors') ?? ['api' => ['Error al actualizar el videojuego']];
            return redirect()
                ->back()
                ->withInput()
                ->withErrors($apiErrors);
        }

        return redirect()->route('game.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Game $game)
    {
        $token = session('api_token'); // Get the token from the session
        $response = Http::withToken($token)->delete(url('/api/game/' . $game->slug));

        if ($response->failed()) {
            $apiErrors = $response->json('errors') ?? ['api' => ['Error al eliminar el videojuego']];
            return redirect()
                ->back()
                ->withInput()
                ->withErrors($apiErrors);
        }

        return redirect()->route('game.index');
    }
}