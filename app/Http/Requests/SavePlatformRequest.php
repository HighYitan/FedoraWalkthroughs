<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SavePlatformRequest extends FormRequest
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
            'nombre'        => 'required|string|min:2|max:100',
            'lanzamiento'   => 'required|integer|digits:4|min:1000|max:' . date('Y'),
            'imagen'        => 'nullable|url|max:255',
            'desarrollador' => 'required|string|exists:companies,name', // El nombre del desarrollador debe existir en la tabla de compañías
        ];
    }
    public function messages()
    {
        return [
            'nombre.required'           => 'El nombre de la plataforma es obligatorio.',
            'nombre.string'             => 'El nombre de la plataforma debe ser una cadena de texto.',
            'nombre.min'                => 'El nombre de la plataforma debe tener al menos 2 caracteres.',
            'nombre.max'                => 'El nombre de la plataforma no puede exceder los 100 caracteres.',
            'lanzamiento.required'      => 'El año de lanzamiento es obligatorio.',
            'lanzamiento.integer'       => 'El año de lanzamiento debe ser un número entero.',
            'lanzamiento.digits'        => 'El año de lanzamiento debe tener 4 dígitos.',
            'lanzamiento.min'           => 'El año de lanzamiento no puede ser anterior a 1000.',
            'lanzamiento.max'           => 'El año de lanzamiento no puede ser posterior al año actual.',
            'imagen.url'                => 'La URL de la imagen debe ser válida.',
            'imagen.max'                => 'La URL de la imagen no puede exceder los 255 caracteres.',
            'desarrollador.required'    => 'El desarrollador es obligatorio.',
            'desarrollador.string'      => 'El desarrollador debe ser una cadena de texto.',
            'desarrollador.exists'      => 'El desarrollador seleccionado no es válido.'
        ];
    }
}
