<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaveNewsRequest;
use App\Http\Resources\NewsResource;
use App\Models\Language;
use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $news = News::all();
        
        return NewsResource::collection($news);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SaveNewsRequest $request)
    {
        $createdNews = News::create([
            'slug' => $request->titulo_inicial
        ]);

        foreach ($request->traducciones as $traduccion) {
            $languageId = Language::where('locale', $traduccion['idioma'])->value('id');
            if (!$languageId) {
                return response()->json(['error' => 'Idioma no encontrado'], 404);
            }
            $createdNews->newsLanguages()->create([
                'title'         => $traduccion['titulo'],
                'content'       => $traduccion['contenido'],
                'image'         => $traduccion['imagen'],
                'news_id'       => $createdNews->id,
                'language_id'   => $languageId
            ]);
        }

        return (new NewsResource($createdNews))->additional(['meta' => 'Noticia creada correctamente']);
    }

    /**
     * Display the specified resource.
     */
    public function show(News $news)
    {
        return new NewsResource($news);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SaveNewsRequest $request, News $news)
    {
        $news->update([
            'slug' => $request->titulo_inicial
        ]);

        foreach ($request->traducciones as $traduccion) {
            $languageId = Language::where('locale', $traduccion['idioma'])->value('id');
            if (!$languageId) {
                return response()->json(['error' => 'Idioma no encontrado'], 404);
            }
            $news->newsLanguages()->updateOrCreate(
                ['language_id' => $languageId],
                [
                    'title'   => $traduccion['titulo'],
                    'content' => $traduccion['contenido'],
                    'image'   => $traduccion['imagen']
                ]
            );
        }

        return (new NewsResource($news))->additional(['meta' => 'Noticia actualizada correctamente']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(News $news)
    {
        $news->load(['newsLanguages']);

        $news->newsLanguages()->delete();
        $news->delete();

        return (new NewsResource($news))->additional(['meta' => 'Noticia eliminada correctamente']);
    }
}
