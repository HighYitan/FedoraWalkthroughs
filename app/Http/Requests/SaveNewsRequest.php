<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveNewsRequest extends FormRequest
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
            'titulo_inicial'            => 'required|string|min:2|max:255',
            'traducciones'              => 'required|array|min:1',
            'traducciones.*.titulo'     => 'required|string|min:2|max:255',
            'traducciones.*.contenido'  => 'required|string|min:6|max:10000',
            'traducciones.*.imagen'     => 'required|url|min:6|max:255',
            'traducciones.*.idioma'     => 'required|string|exists:languages,locale',
        ];
    }
    public function messages()
    {
        return [
            'titulo_inicial.required'           => "Título inicial es obligatorio",
            'titulo_inicial.string'             => "Título inicial ha de ser una cadena de texto",
            'titulo_inicial.min'                => "Mínimo 2 car para el título inicial",
            'titulo_inicial.max'                => "Máximo 255 car para el título inicial",
            'traducciones.required'             => "Traducciones son obligatorias",
            'traducciones.array'                => "Traducciones ha de ser un array",
            'traducciones.min'                  => "Debe haber al menos una traducción",
            'traducciones.*.titulo.required'    => "Título de la traducción es obligatorio",
            'traducciones.*.titulo.string'      => "Título de la traducción ha de ser una cadena de texto",
            'traducciones.*.titulo.min'         => "Mínimo 2 car para el título de la traducción",
            'traducciones.*.titulo.max'         => "Máximo 255 car para el título de la traducción",
            'traducciones.*.contenido.required' => "Contenido de la traducción es obligatorio",
            'traducciones.*.contenido.string'   => "Contenido de la traducción ha de ser una cadena de texto",
            'traducciones.*.contenido.min'      => "Mínimo 6 car para el contenido de la traducción",
            'traducciones.*.contenido.max'      => "Máximo 10000 car para el contenido de la traducción",
            'traducciones.*.idioma.required'    => "Idioma de la traducción es obligatorio",
            'traducciones.*.imagen.url'         => "Imagen de la traducción ha de ser una URL",
            'traducciones.*.imagen.min'         => "Mínimo 6 car para la imagen de la traducción",
            'traducciones.*.imagen.max'         => "Máximo 255 car para la imagen de la traducción",
            'traducciones.*.idioma.required'    => "Idioma de la traducción es obligatorio",
            'traducciones.*.idioma.string'      => "Idioma de la traducción ha de ser una cadena de texto",
            'traducciones.*.idioma.exists'      => "Idioma de la traducción no existe",
        ];
    }
}
