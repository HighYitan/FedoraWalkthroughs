<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Foundation\Http\FormRequest;

class SaveGuideRequest extends FormRequest
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
            'titulo'                                    => 'required|string|min:6|max:100',
            'contenidos'                                => 'required|array|min:1',
            'contenidos.*.nombre'                       => 'required|string|min:2|max:100',
            'contenidos.*.contenido'                    => 'required|string|min:6|max:10000',
            'lanzamiento_id'                            => 'required|integer|exists:game_releases,id',
            'idioma'                                    => 'required|string|exists:languages,locale',
            'correo'                                    => 'required|string|email|min:6|max:100|exists:users,email|regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/',
        ];
    }
    public function messages()
    {
        return [
            'titulo.required'                           => "Título es obligatorio",
            'titulo.string'                             => "Título ha de ser una cadena de texto",
            'titulo.min'                                => "Mínimo 6 car",
            'titulo.max'                                => "Máximo 100 car",
            'contenidos.required'                       => "Contenidos son obligatorios",
            'contenidos.array'                          => "Contenidos ha de ser un array",
            'contenidos.min'                            => "Debe haber al menos un contenido",
            'contenidos.*.nombre.required'              => "Nombre del contenido es obligatorio",
            'contenidos.*.nombre.string'                => "Nombre del contenido ha de ser una cadena de texto",
            'contenidos.*.nombre.min'                   => "Mínimo 6 car para el nombre del contenido",
            'contenidos.*.nombre.max'                   => "Máximo 100 car para el nombre del contenido",
            'contenidos.*.contenido.required'           => "Contenido es obligatorio",
            'contenidos.*.contenido.string'             => "Contenido ha de ser una cadena de texto",
            'contenidos.*.contenido.min'                => "Mínimo 6 car para el contenido",
            'contenidos.*.contenido.max'                => "Máximo 10000 car para el contenido",
            'lanzamiento_id.required'                   => "Lanzamiento es obligatorio",
            'lanzamiento_id.integer'                    => "Lanzamiento ha de ser un número entero",
            'lanzamiento_id.exists'                     => "Lanzamiento no existe",
            'idioma.required'                           => "Idioma es obligatorio",
            'idioma.string'                             => "Idioma ha de ser una cadena de texto",
            'idioma.exists'                             => "Idioma no existe",
            'correo.required'                           => "Correo es obligatorio",
            'correo.string'                             => "Correo ha de ser una cadena de texto",
            'correo.email'                              => "Correo ha de ser un correo válido",
            'correo.min'                                => "Mínimo 6 car para el correo",
            'correo.max'                                => "Máximo 100 car para el correo",
            'correo.unique'                             => "Correo ya en uso",
            'correo.regex'                              => "Correo ha de ser un correo válido",
        ];
    }
    public function prepareForValidation()
    {
        $data = $this->all();

        if ($this->filled('lanzamiento_id')) {
            $data['lanzamiento_id'] = Crypt::decryptString($this->input('lanzamiento_id'));
        }

        $this->replace($data);
    }
}
