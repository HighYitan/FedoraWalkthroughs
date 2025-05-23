<?php

namespace App\Http\Resources;

use App\Http\Resources\GameResource;
use App\Http\Resources\GenreTranslationResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GenreResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "nombre_inicial" => $this->slug,
            "traducciones" => GenreTranslationResource::collection($this->genreTranslations),
            "videojuegos" => $this->when(
                $this->relationLoaded('games') && $this->games && $this->games->isNotEmpty() && !$this->isFromApiGame($request),
                GameResource::collection($this->games),
            ),
        ];
    }
    private function isFromApiGame(Request $request): bool
    {
        return strpos($request->getPathInfo(), '/api/game') !== false;
    }
}
