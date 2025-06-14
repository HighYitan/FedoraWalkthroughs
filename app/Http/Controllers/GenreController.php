<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GenreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $token = session('api_token');
        $response = Http::withToken($token)->get(url('/api/genre'));

        $genres = $response->json('data');

        return view('genre.index', ['genres' => $genres]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('genre.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();

        foreach ($data['traducciones'] as $traduccion) {
            if (isset($traduccion['idioma']) && $traduccion['idioma'] === 'ES') {
                $nombreInicial = $traduccion['nombre'] ?? '';
                break;
            }
        }
        $data['nombre_inicial'] = $nombreInicial;

        $token = session('api_token');
        $response = Http::withToken($token)->withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ])->post(url('/api/genre'), $data);

        if ($response->failed()) {
            $apiErrors = $response->json('errors') ?? ['api' => ['Error al crear el género']];
            return redirect()
                ->back()
                ->withInput()
                ->withErrors($apiErrors);
        }

        return redirect()->route('genre.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Genre $genre)
    {
        $token = session('api_token');
        $response = Http::withToken($token)->get(url('/api/genre/' . $genre->slug));

        $genre = $response->json('data');

        return view('genre.show', ['genre' => $genre]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Genre $genre)
    {
        $token = session('api_token');
        $response = Http::withToken($token)->get(url('/api/genre/' . $genre->slug));

        $genre = $response->json('data');

        return view('genre.edit', ['genre' => $genre]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Genre $genre)
    {
        $data = $request->all();

        foreach ($data['traducciones'] as $traduccion) {
            if (isset($traduccion['idioma']) && $traduccion['idioma'] === 'ES') {
                $nombreInicial = $traduccion['nombre'] ?? '';
                break;
            }
        }
        $data['nombre_inicial'] = $nombreInicial;

        $token = session('api_token');
        $response = Http::withToken($token)->withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ])->put(url('/api/genre/' . $genre->slug), $data);

        if ($response->failed()) {
            $apiErrors = $response->json('errors') ?? ['api' => ['Error al actualizar el género']];
            return redirect()
                ->back()
                ->withInput()
                ->withErrors($apiErrors);
        }

        return redirect()->route('genre.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Genre $genre)
    {
        $token = session('api_token');
        $response = Http::withToken($token)->delete(url('/api/genre/' . $genre->slug));

        if ($response->failed()) {
            $apiErrors = $response->json('errors') ?? ['api' => ['Error al eliminar el género']];
            return redirect()
                ->back()
                ->withErrors($apiErrors);
        }

        return redirect()->route('genre.index');
    }
}
