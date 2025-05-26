<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaveGenreRequest;
use App\Http\Resources\GenreResource;
use App\Models\Genre;
use App\Models\Language;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $genres = Genre::all();

        return GenreResource::collection($genres);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SaveGenreRequest $request)
    {
        $createdGenre = Genre::create([
            'slug' => $request->nombre_inicial,
        ]);

        foreach ($request->traducciones as $traduccion) {
            $languageId = Language::where('locale', $traduccion['idioma'])->value('id');
            if (!$languageId) {
                return response()->json(['error' => 'Idioma no encontrado'], 404);
            }
            $createdGenre->genreTranslations()->create([
                'name' => $traduccion['nombre'],
                'description' => $traduccion['descripcion'],
                'language_id' => $languageId,
            ]);
        }

        return (new GenreResource($createdGenre))->additional(['meta' => 'Género creado correctamente']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Genre $genre)
    {
        // SELECCIÓ DE LES DADES
        $genre->load([
            "games"
        ]);
        return new GenreResource($genre);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SaveGenreRequest $request, Genre $genre)
    {
        $genre->slug = $request->nombre_inicial;
        $genre->save();

        // Actualizar traducciones
        foreach ($request->traducciones as $traduccion) {
            $languageId = Language::where('locale', $traduccion['idioma'])->value('id');
            if (!$languageId) {
                return response()->json(['error' => 'Idioma no encontrado'], 404);
            }
            $genreTranslation = $genre->genreTranslations()->updateOrCreate( // Busca (Actualiza) o crea la traducción
                ['language_id' => $languageId],
                [
                    'name' => $traduccion['nombre'],
                    'description' => $traduccion['descripcion'],
                ]
            );
        }

        return (new GenreResource($genre))->additional(['meta' => 'Género actualizado correctamente']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Genre $genre)
    {
        $genre->load([ // Para que muestre las traducciones antes de que se eliminen en el resource, si no se muestra el array vacío en el JSON.
            'genreTranslations',
        ]);

        // Desvincular géneros de los juegos
        $genre->games()->detach();

        // Eliminar traducciones
        $genre->genreTranslations()->delete();

        // Eliminar el género
        $genre->delete();

        return (new GenreResource($genre))->additional(['meta' => 'Género eliminado correctamente']);
    }
}
