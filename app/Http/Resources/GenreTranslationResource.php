<?php

namespace App\Http\Resources;

use App\Http\Resources\LanguageResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GenreTranslationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "nombre"        => $this->name,
            "descripcion"   => $this->description,
            "idioma"        => new LanguageResource($this->language),
        ];
    }
}
