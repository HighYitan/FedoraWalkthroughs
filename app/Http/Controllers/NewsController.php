<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $token = session('api_token');
        $response = Http::withToken($token)->get(url('/api/news'));

        if ($response->failed()) {
            return redirect()->back()->withErrors(['api' => 'Error al obtener las noticias']);
        }

        $news = $response->json('data');

        return view('news.index', ['news' => $news]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('news.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();

        foreach ($data['traducciones'] as $traduccion) {
            if (isset($traduccion['idioma']) && $traduccion['idioma'] === 'ES') {
                $tituloInicial = $traduccion['titulo'] ?? '';
                break;
            }
        }
        $data['titulo_inicial'] = $tituloInicial;

        $token = session('api_token');
        $response = Http::withToken($token)->withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ])->post(url('/api/news'), $data);

        if ($response->failed()) {
            $apiErrors = $response->json('errors') ?? ['api' => ['Error al crear la noticia']];
            return redirect()
                ->back()
                ->withInput()
                ->withErrors($apiErrors);
        }

        return redirect()->route('news.index')->with('success', 'Noticia creada correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(News $news)
    {
        $token = session('api_token');
        $response = Http::withToken($token)->get(url('/api/news/' . $news->slug));

        if ($response->failed()) {
            return redirect()->back()->withErrors(['api' => 'Error al obtener la noticia']);
        }

        $newsData = $response->json('data');

        return view('news.show', ['news' => $newsData]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(News $news)
    {
        $token = session('api_token');
        $response = Http::withToken($token)->get(url('/api/news/' . $news->slug));

        if ($response->failed()) {
            return redirect()->back()->withErrors(['api' => 'Error al obtener la noticia']);
        }

        $newsData = $response->json('data');

        return view('news.edit', ['news' => $newsData]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, News $news)
    {
        $data = $request->all();

        foreach ($data['traducciones'] as $traduccion) {
            if (isset($traduccion['idioma']) && $traduccion['idioma'] === 'ES') {
                $tituloInicial = $traduccion['titulo'] ?? '';
                break;
            }
        }
        $data['titulo_inicial'] = $tituloInicial;

        $token = session('api_token');
        $response = Http::withToken($token)->withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ])->put(url('/api/news/' . $news->slug), $data);

        if ($response->failed()) {
            $apiErrors = $response->json('errors') ?? ['api' => ['Error al actualizar la noticia']];
            return redirect()
                ->back()
                ->withInput()
                ->withErrors($apiErrors);
        }

        return redirect()->route('news.index')->with('success', 'Noticia actualizada correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(News $news)
    {
        $token = session('api_token');
        $response = Http::withToken($token)->delete(url('/api/news/' . $news->slug));

        if ($response->failed()) {
            return redirect()->back()->withErrors(['api' => 'Error al eliminar la noticia']);
        }

        return redirect()->route('news.index')->with('success', 'Noticia eliminada correctamente');
    }
}
