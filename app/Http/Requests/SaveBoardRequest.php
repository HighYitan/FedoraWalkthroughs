<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Crypt;

class SaveBoardRequest extends FormRequest
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
            'titulo'        => 'required|string|min:2|max:100', //Los nombres más cortos son de 2 letras
            'descripcion'   => 'required|string|min:6|max:5000',
            'lanzamiento'   => 'required|integer|exists:game_releases,id',
            'idioma'        => 'required|string|exists:languages,locale',
            'autor'         => 'required|string|email|min:6|max:100|exists:users,email|regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/'
        ];
    }
    public function messages()
    {
        return [
            'titulo.required'       => "Título es obligatorio",
            'titulo.string'         => "Título ha de ser una cadena de texto",
            'titulo.min'            => "Mínimo 2 car",
            'titulo.max'            => "Máximo 100 car",
            'descripcion.required'  => "Descripción es obligatoria",
            'descripcion.string'    => "Descripción ha de ser una cadena de texto",
            'descripcion.min'       => "Mínimo 6 car",
            'descripcion.max'       => "Máximo 5000 car",
            'lanzamiento.required'  => "Lanzamiento es obligatorio",
            'lanzamiento.integer'   => "Lanzamiento ha de ser un número entero",
            'lanzamiento.exists'    => "Lanzamiento no existe",
            'idioma.required'       => "Idioma es obligatorio",
            'idioma.string'         => "Idioma ha de ser una cadena de texto",
            'idioma.exists'         => "Idioma no existe",
            'autor.required'        => "Autor es obligatorio",
            'autor.string'          => "Autor ha de ser una cadena de texto",
            'autor.email'           => "Autor ha de ser un correo válido",
            'autor.min'             => "Mínimo 6 car",
            'autor.max'             => "Máximo 100 car",
            'autor.unique'          => "Autor ya en uso",
            'autor.regex'           => "Autor ha de ser un correo válido",
        ];
    }
    public function prepareForValidation()
    {
        $data = $this->all();

        if ($this->filled('lanzamiento')) {
            $data['lanzamiento'] = Crypt::decryptString($this->input('lanzamiento'));
        }

        $this->replace($data);
    }
}
