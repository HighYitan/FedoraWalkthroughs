<?php

namespace App\Http\Requests;

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
            'titulo'                                    => 'required|string|min:2|max:100',
            'contenidos'                                => 'required|array|min:1',
            'contenidos.*.nombre'                       => 'required|string|min:6|max:100',
            'contenidos.*.contenido'                    => 'required|string|min:6|max:10000',
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

        ];
    }
    public function prepareForValidation()
    {
        $data = $this->all();

        if ($this->filled('grado_id')) {
            $data['grado_id'] = Crypt::decryptString($this->input('grado_id'));
        }

        $this->replace($data);
    }
}
