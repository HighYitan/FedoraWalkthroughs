<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Crypt;

class SaveContentRequest extends FormRequest
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
            'nombre'    => 'required|string|min:2|max:100',
            'contenido' => 'required|string|min:6|max:10000',
            'guia_id'   => 'required|integer|exists:guides,id',
        ];
    }
    public function messages()
    {
        return [
            'nombre.required'    => "Nombre es obligatorio",
            'nombre.string'      => "Nombre ha de ser una cadena de texto",
            'nombre.min'         => "Mínimo 2 car para el nombre",
            'nombre.max'         => "Máximo 100 car para el nombre",
            'contenido.required' => "Contenido es obligatorio",
            'contenido.string'   => "Contenido ha de ser una cadena de texto",
            'contenido.min'      => "Mínimo 6 car para el contenido",
            'contenido.max'      => "Máximo 10000 car para el contenido",
            'guia_id.required'   => "Guía es obligatoria",
            'guia_id.integer'    => "Guía ha de ser un número entero",
            'guia_id.exists'     => "Guía no existe",
        ];
    }
    public function prepareForValidation()
    {
        $data = $this->all();

        if ($this->filled('guia_id')) {
            $data['guia_id'] = Crypt::decryptString($this->input('guia_id'));
        }

        $this->replace($data);
    }
}
