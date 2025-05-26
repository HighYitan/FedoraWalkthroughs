<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveGenreRequest extends FormRequest
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
            'nombre_inicial'                => 'required|string|min:2|max:100',
            'traducciones'                  => 'required|array|min:1',
            'traducciones.*.nombre'         => 'required|string|min:2|max:100',
            'traducciones.*.descripcion'    => 'nullable|string|min:6|max:1000',
            'traducciones.*.idioma'         => 'required|string|exists:languages,locale',
        ];
    }
    public function messages()
    {
        return [
            'nombre_inicial.required'           => 'El nombre inicial del género es obligatorio.',
            'nombre_inicial.string'             => 'El nombre inicial del género debe ser una cadena de texto.',
            'nombre_inicial.min'                => 'El nombre inicial del género debe tener al menos 2 caracteres.',
            'nombre_inicial.max'                => 'El nombre inicial del género no puede exceder los 100 caracteres.',
            'traducciones.required'             => 'Las traducciones son obligatorias.',
            'traducciones.array'                => 'Las traducciones deben ser un array.',
            'traducciones.min'                  => 'Debe haber al menos una traducción.',
            'traducciones.*.nombre.required'    => 'El nombre de la traducción es obligatorio.',
            'traducciones.*.nombre.string'      => 'El nombre de la traducción debe ser una cadena de texto.',
            'traducciones.*.nombre.min'         => 'El nombre de la traducción debe tener al menos 2 caracteres.',
            'traducciones.*.nombre.max'         => 'El nombre de la traducción no puede exceder los 100 caracteres.',
            'traducciones.*.descripcion.string' => 'La descripción de la traducción debe ser una cadena de texto.',
            'traducciones.*.descripcion.min'    => 'La descripción de la traducción debe tener al menos 6 caracteres.',
            'traducciones.*.descripcion.max'    => 'La descripción de la traducción no puede exceder los 1000 caracteres.',
            'traducciones.*.idioma.required'    => 'El idioma de la traducción es obligatorio.',
            'traducciones.*.idioma.string'      => 'El idioma de la traducción debe ser una cadena de texto.',
            'traducciones.*.idioma.exists'      => 'El idioma seleccionado no es válido.'
        ];
    }
}
