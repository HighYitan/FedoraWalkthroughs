<?php

namespace App\Http\Resources;

use App\Http\Resources\ContentGuideResource;
use App\Http\Resources\GameReleaseResource;
use App\Http\Resources\GuideRatingResource;
use App\Http\Resources\LanguageResource;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Crypt;

class GuideResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"        => Crypt::encryptString($this->id),
            "titulo"    => $this->title,
            "puntuacion_media"  => $this->when(!is_null($this->rating), $this->rating),
            "aprobada" => $this->is_approved ? 'Sí' : 'No',
            "usuario" => new UserResource($this->user),
            "contenidos" => ContentGuideResource::collection($this->whenLoaded('contentGuides')),
            "lanzamiento" => $this->when(
                !$this->isFromApiGameRelease($request),
                new GameReleaseResource($this->gameRelease)
            ),
            "idioma" => new LanguageResource($this->language),
            "puntuaciones"   => $this->when(
                $this->relationLoaded('guideRatings') && $this->guideRatings && $this->guideRatings->isNotEmpty(),
                GuideRatingResource::collection($this->guideRatings),
            ),
        ];
    }
    private function isFromApiUser(Request $request): bool
    {
        return strpos($request->getPathInfo(), '/api/user') !== false;
    }
    private function isFromApiGameRelease(Request $request): bool
    {
        return strpos($request->getPathInfo(), '/api/gameRelease') !== false;
    }
}
