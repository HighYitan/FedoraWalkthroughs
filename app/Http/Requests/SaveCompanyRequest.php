<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveCompanyRequest extends FormRequest
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
            'fundacion'     => 'nullable|integer|digits:4|min:1000|max:' . date('Y'),
            'pais'          => 'required|string|exists:languages,locale',
            'web'           => 'nullable|url|max:255',
            'imagen'        => 'nullable|url|max:255'
        ];
    }
    public function messages()
    {
        return [
            'nombre.required'       => 'El nombre de la compañía es obligatorio.',
            'nombre.string'         => 'El nombre de la compañía debe ser una cadena de texto.',
            'nombre.min'            => 'El nombre de la compañía debe tener al menos 2 caracteres.',
            'nombre.max'            => 'El nombre de la compañía no puede exceder los 100 caracteres.',
            'fundacion.integer'     => 'El año de fundación debe ser un número entero.',
            'fundacion.digits'      => 'El año de fundación debe tener 4 dígitos.',
            'fundacion.min'         => 'El año de fundación no puede ser anterior a 1000.',
            'fundacion.max'         => 'El año de fundación no puede ser posterior al año actual.',
            'pais.required'         => 'El país es obligatorio.',
            'pais.string'           => 'El país debe ser una cadena de texto.',
            'pais.exists'           => 'El país seleccionado no es válido.',
            'web.url'               => 'La URL del sitio web debe ser válida.',
            'web.max'               => 'La URL del sitio web no puede exceder los 255 caracteres.',
            'imagen.url'            => 'La URL de la imagen debe ser válida.',
            'imagen.max'            => 'La URL de la imagen no puede exceder los 255 caracteres.'
        ];
    }
}
