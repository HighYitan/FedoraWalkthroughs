<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LanguageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "abreviatura"        => $this->locale,
            "nombre"        => $this->name,
            "bandera"  => $this->when(!is_null($this->flag), $this->flag),
        ];
    }
}
