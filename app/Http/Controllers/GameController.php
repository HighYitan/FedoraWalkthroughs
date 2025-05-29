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
        $token = session('api_token'); // Get the token from the session
        $response = Http::withToken($token)->get(url('/api/game'));
        // Get the data from the API response
        $games = $response->json('data');
        //dd($games); // Debugging line to check the data structure
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
    public function edit(string $id)
    {
        //
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
