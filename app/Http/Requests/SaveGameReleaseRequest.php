<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveGameReleaseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nombre_inicial'                            => 'required|string|min:2|max:255|exists:games,slug',
            'nombre'                                    => 'required|string|min:2|max:255',
            'lanzamiento'                               => 'required|date',
            'region'                                    => 'required|string|exists:regions,slug',
            'plataformas'                               => 'required|array|min:1',
            'plataformas.*.plataforma'                  => 'required|string|min:2|max:100|exists:platforms,name',
            'desarrolladores'                           => 'required|array|min:1',
            'desarrolladores.*.nombre'                  => 'required|string|min:2|max:100|exists:companies,name',
            'distribuidores'                            => 'required|array|min:1',
            'distribuidores.*.nombre'                   => 'required|string|min:2|max:100|exists:companies,name',
        ];
    }
    public function messages()
    {
        return [
            'nombre_inicial.required'                   => "El nombre inicial del videojuego es obligatorio.",
            'nombre_inicial.string'                     => "El nombre inicial del videojuego debe ser una cadena de texto.",
            'nombre_inicial.min'                        => "El nombre inicial del videojuego debe tener al menos 2 caracteres.",
            'nombre_inicial.max'                        => "El nombre inicial del videojuego no puede exceder los 255 caracteres.",
            'nombre.required'                           => "El nombre de la versión es obligatorio.",
            'nombre.string'                             => "El nombre de la versión debe ser una cadena de texto.",
            'nombre.min'                                => "El nombre de la versión debe tener al menos 2 caracteres.",
            'nombre.max'                                => "El nombre de la versión no puede exceder los 255 caracteres.",
            'lanzamiento.required'                      => "La fecha de lanzamiento es obligatoria.",
            'lanzamiento.date'                          => "La fecha de lanzamiento debe ser una fecha válida.",
            'region.required'                           => "La región es obligatoria.",
            'region.string'                             => "La región debe ser una cadena de texto.",
            'region.exists'                             => "La región seleccionada no es válida.",
            'plataformas.required'                      => "Las plataformas son obligatorias.",
            'plataformas.array'                         => "Las plataformas deben ser un array.",
            'plataformas.min'                           => "Debe seleccionar al menos una plataforma.",
            'plataformas.*.plataforma.required'         => "La plataforma es obligatoria.",
            'plataformas.*.plataforma.string'           => "La plataforma debe ser una cadena de texto.",
            'plataformas.*.plataforma.min'              => "La plataforma debe tener al menos 2 caracteres.",
            'plataformas.*.plataforma.max'              => "La plataforma no puede exceder los 100 caracteres.",
            'plataformas.*.plataforma.exists'           => "La plataforma seleccionada no es válida.",
            'desarrolladores.required'                  => "Los desarrolladores son obligatorios.",
            'desarrolladores.array'                     => "Los desarrolladores deben ser un array.",
            'desarrolladores.min'                       => "Debe seleccionar al menos un desarrollador.",
            'desarrolladores.*.nombre.required'         => "El nombre del desarrollador es obligatorio.",
        ];  
    }
}
