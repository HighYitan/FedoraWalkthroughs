<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveGameRequest extends FormRequest
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
            'nombre_inicial'                            => 'required|string|min:2|max:255',
            'traducciones'                              => 'required|array|min:1',
            'traducciones.*.descripcion'                => 'required|string|min:6|max:5000',
            'traducciones.*.idioma'                     => 'required|string|exists:languages,locale',
            'generos'                                   => 'required|array|min:1',
            'generos.*.nombre_inicial'                  => 'required|string|exists:genres,slug',
            'lanzamientos'                              => 'required|array|min:1',
            'lanzamientos.*.nombre'                     => 'required|string|min:2|max:255',
            'lanzamientos.*.lanzamiento'                => 'required|date',
            'lanzamientos.*.region'                     => 'required|string|exists:regions,slug',
            'lanzamientos.*.plataformas'                => 'required|array|min:1',
            'lanzamientos.*.plataformas.*.plataforma'   => 'required|string|min:2|max:100|exists:platforms,name',
            'lanzamientos.*.desarrolladores'            => 'required|array|min:1',
            'lanzamientos.*.desarrolladores.*.nombre'   => 'required|string|min:2|max:100|exists:companies,name',
            'lanzamientos.*.distribuidores'             => 'required|array|min:1',
            'lanzamientos.*.distribuidores.*.nombre'    => 'required|string|min:2|max:100|exists:companies,name',
            'imagen'                                    => 'nullable|url|min:6|max:255',
            'video'                                     => 'nullable|url|min:6|max:255',
            'web'                                       => 'nullable|url|min:6|max:255',
        ];
    }
    public function messages()
    {
        return [
            'nombre_inicial.required'                           => "Nombre inicial es obligatorio",
            'nombre_inicial.string'                             => "Nombre inicial ha de ser una cadena de texto",
            'nombre_inicial.min'                                => "Mínimo 2 car",
            'nombre_inicial.max'                                => "Máximo 255 car",
            'traducciones.required'                             => "Traducciones son obligatorias",
            'traducciones.array'                                => "Traducciones han de ser un array",
            'traducciones.min'                                  => "Mínimo 1 traducción",
            'traducciones.*.descripcion.required'               => "Descripción es obligatoria",
            'traducciones.*.descripcion.string'                 => "Descripción ha de ser una cadena de texto",
            'traducciones.*.descripcion.min'                    => "Mínimo 6 car",
            'traducciones.*.descripcion.max'                    => "Máximo 5000 car",
            'traducciones.*.idioma.required'                    => "Idioma es obligatorio",
            'traducciones.*.idioma.string'                      => "Idioma ha de ser una cadena de texto",
            'traducciones.*.idioma.exists'                      => "Idioma no existe",
            'generos.required'                                  => "Géneros son obligatorios",
            'generos.array'                                     => "Géneros han de ser un array",
            'generos.min'                                       => "Mínimo 1 género",
            'generos.*.nombre_inicial.required'                 => "Nombre inicial es obligatorio",
            'generos.*.nombre_inicial.string'                   => "Nombre inicial ha de ser una cadena de texto",
            'generos.*.nombre_inicial.exists'                   => "Género no existe",
            'lanzamientos.required'                             => "Lanzamientos son obligatorios",
            'lanzamientos.array'                                => "Lanzamientos han de ser un array",
            'lanzamientos.min'                                  => "Mínimo 1 lanzamiento",
            'lanzamientos.*.nombre.required'                    => "Nombre es obligatorio",
            'lanzamientos.*.nombre.string'                      => "Nombre ha de ser una cadena de texto",
            'lanzamientos.*.nombre.min'                         => "Mínimo 2 car",
            'lanzamientos.*.nombre.max'                         => "Máximo 255 car",
            'lanzamientos.*.lanzamiento.required'               => "Lanzamiento es obligatorio",
            'lanzamientos.*.lanzamiento.date'                   => "Lanzamiento ha de ser una fecha",
            'lanzamientos.*.region.required'                    => "Región es obligatoria",
            'lanzamientos.*.region.string'                      => "Región ha de ser una cadena de texto",
            'lanzamientos.*.region.exists'                      => "Región no existe",
            'lanzamientos.*.plataformas.required'               => "Plataformas son obligatorias",
            'lanzamientos.*.plataformas.array'                  => "Plataformas han de ser un array",
            'lanzamientos.*.plataformas.min'                    => "Mínimo 1 plataforma",
            'lanzamientos.*.plataformas.*.plataforma.required'  => "Plataforma es obligatoria",
            'lanzamientos.*.plataformas.*.plataforma.string'    => "Plataforma ha de ser una cadena de texto",
            'lanzamientos.*.plataformas.*.plataforma.min'       => "Mínimo 2 car",
            'lanzamientos.*.plataformas.*.plataforma.max'       => "Máximo 100 car",
            'lanzamientos.*.desarrolladores.required'           => "Desarrolladores son obligatorios",
            'lanzamientos.*.desarrolladores.array'              => "Desarrolladores han de ser un array",
            'lanzamientos.*.desarrolladores.min'                => "Mínimo 1 desarrollador",
            'lanzamientos.*.desarrolladores.*.nombre.required'  => "Nombre es obligatorio",
            'lanzamientos.*.desarrolladores.*.nombre.string'    => "Nombre ha de ser una cadena de texto",
            'lanzamientos.*.desarrolladores.*.nombre.min'       => "Mínimo 2 car",
            'lanzamientos.*.desarrolladores.*.nombre.max'       => "Máximo 100 car",
            'lanzamientos.*.desarrolladores.*.nombre.exists'    => "Desarrollador no existe",
            'lanzamientos.*.distribuidores.required'            => "Distribuidores son obligatorios",
            'lanzamientos.*.distribuidores.array'               => "Distribuidores han de ser un array",
            'lanzamientos.*.distribuidores.min'                 => "Mínimo 1 distribuidor",
            'lanzamientos.*.distribuidores.*.nombre.required'   => "Nombre es obligatorio",
            'lanzamientos.*.distribuidores.*.nombre.string'     => "Nombre ha de ser una cadena de texto",
            'lanzamientos.*.distribuidores.*.nombre.min'        => "Mínimo 2 car",
            'lanzamientos.*.distribuidores.*.nombre.max'        => "Máximo 100 car",
            'lanzamientos.*.distribuidores.*.nombre.exists'     => "Distribuidor no existe",
            'imagen.url'                                        => "Imagen ha de ser una URL",
            'imagen.min'                                        => "Mínimo 6 car",
            'imagen.max'                                        => "Máximo 255 car",
            'video.url'                                         => "Video ha de ser una URL",
            'video.min'                                         => "Mínimo 6 car",
            'video.max'                                         => "Máximo 255 car",
            'web.url'                                           => "Web ha de ser una URL",
            'web.min'                                           => "Mínimo 6 car",
            'web.max'                                           => "Máximo 255 car",
        ];  
    }
}
