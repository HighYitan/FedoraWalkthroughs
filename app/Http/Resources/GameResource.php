<?php

namespace App\Http\Resources;

use App\Http\Resources\GameRatingResource;
use App\Http\Resources\GameReleaseResource;
use App\Http\Resources\GameTranslationResource;
use App\Http\Resources\GenreResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GameResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "nombre_inicial"    => $this->slug,
            "puntuacion_media"  => $this->when(!is_null($this->rating), $this->rating),
            "destacado" => $this->featured === 'Y' ? 'Sí' : 'No',
            "imagen"            => $this->when(!is_null($this->image), $this->image),
            "video"             => $this->when(!is_null($this->video), $this->video),
            "web"               => $this->when(!is_null($this->website), $this->website),
            "traducciones"      => GameTranslationResource::collection($this->gameTranslations),
            "generos"   => $this->when(
                $this->genres && $this->genres->isNotEmpty() && !$this->isFromApiGenre($request),
                GenreResource::collection($this->genres),
            ),
            "lanzamientos"   => $this->when(
                $this->relationLoaded('gameReleases') && $this->gameReleases && $this->gameReleases->isNotEmpty() && !$this->isFromApiGameRelease($request),
                GameReleaseResource::collection($this->gameReleases),
            ),
            "puntuaciones"   => $this->when(
                $this->relationLoaded('gameRatings') && $this->gameRatings && $this->gameRatings->isNotEmpty() && !$this->isFromApiUser($request),
                GameRatingResource::collection($this->gameRatings),
            ),
        ];
    }
    private function isFromApiGenre(Request $request): bool
    {
        return strpos($request->getPathInfo(), '/api/genre') !== false;
    }
    private function isFromApiGameRelease(Request $request): bool
    {
        return strpos($request->getPathInfo(), '/api/gameRelease') !== false;
    }
    private function isFromApiUser(Request $request): bool
    {
        return strpos($request->getPathInfo(), '/api/user') !== false;
    }
}
