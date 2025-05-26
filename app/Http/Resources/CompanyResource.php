<?php

namespace App\Http\Resources;

use App\Http\Resources\GameDeveloperResource;
use App\Http\Resources\GamePublisherResource;
use App\Http\Resources\PlatformResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
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
            "fundacion"     => $this->foundation_year,
            "pais"          => $this->language->locale,
            "web"           => $this->website,
            "imagen"        => $this->image,
            "plataformas" => $this->when(
                $this->platforms && $this->platforms->isNotEmpty() && !$this->isFromApiPlatform($request),
                PlatformResource::collection($this->platforms),
            ),
            "desarrollaron" => $this->when(
                $this->relationLoaded('gameDevelopers') && $this->gameDevelopers && $this->gameDevelopers->isNotEmpty(),
                GameDeveloperResource::collection($this->gameDevelopers)
            ),
            "distribuyeron"    => $this->when(
                $this->relationLoaded('gamePublishers') && $this->gamePublishers && $this->gamePublishers->isNotEmpty(),
                GamePublisherResource::collection($this->gamePublishers)
            ),
        ];
    }
    private function isFromApiPlatform(Request $request): bool
    {
        return strpos($request->getPathInfo(), '/api/platform') !== false;
    }
}
