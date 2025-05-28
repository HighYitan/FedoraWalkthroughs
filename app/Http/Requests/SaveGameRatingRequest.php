<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveGameRatingRequest extends FormRequest
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
            'puntuacion'    => 'required|decimal:2|between:0.00,10.00',
            'videojuego'    => 'required|string|exists:games,slug',
            'usuario'       => 'required|string|email|min:6|max:100|exists:users,email|regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/',
        ];
    }
    public function messages()
    {
        return [
            'puntuacion.required'   => "Puntuación es obligatoria",
            'puntuacion.decimal'    => "Puntuación ha de ser un número decimal con 2 decimales",
            'puntuacion.between'    => "Puntuación ha de estar entre 0.00 y 10.00",
            'videojuego.required'   => "Videojuego es obligatorio",
            'videojuego.string'     => "Videojuego ha de ser una cadena de texto",
            'videojuego.exists'     => "Videojuego no existe",
            'usuario.required'      => "Usuario es obligatorio",
            'usuario.string'        => "Usuario ha de ser una cadena de texto",
            'usuario.email'         => "Usuario ha de ser un correo válido",
            'usuario.min'           => "Mínimo 6 car para el usuario",
            'usuario.max'           => "Máximo 100 car para el usuario",
            'usuario.exists'        => "Usuario no existe",
            'usuario.regex'         => "Usuario ha de ser un correo válido",
        ];
    }
}
