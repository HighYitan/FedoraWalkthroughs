<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveUserRequest extends FormRequest
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
            'nombre'        => 'nullable|string|min:2|max:50', //Los nombres más cortos son de 2 letras
            'correo'        => 'nullable|string|email|min:6|max:100|unique:users,email,' . $this->user->id . '|regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/',
            'contraseña'    => 'nullable|string|min:6|max:100|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/|regex:/[@$!%*?&]/',
            'baneado'       => 'nullable|in:Y,N',
            'rol'           => 'nullable|string|exists:roles,name',
        ];
    }
    public function messages()
    {
        return [
            'nombre.min'            => "Mínimo 2 car",
            'nombre.max'            => "Máximo 50 car",
            'nombre.string'         => "Nombre ha de ser una cadena de texto",
            'correo.string'         => "Correo ha de ser una cadena de texto",
            'correo.email'          => "Correo ha de ser un correo válido",
            'correo.min'            => "Mínimo 6 car",
            'correo.max'            => "Máximo 100 car",
            'correo.unique'         => "Correo ya en uso",
            'correo.regex'          => "Correo ha de ser un correo válido",
            'contraseña.min'        => "Mínimo 6 car",
            'contraseña.max'        => "Máximo 100 car",
            'contraseña.string'     => "Contraseña ha de ser una cadena de texto",
            'contraseña.regex'      => "contraseña debe contener al menos una minúscula, una mayúscula, un número y un carácter especial",
            'baneado.in'            => "Baneado debe ser 'Y' o 'N'",
            'rol.string'            => "El rol ha de ser una cadena de texto",
            'rol.exists'            => "El rol no existe",
        ];
    }
}
