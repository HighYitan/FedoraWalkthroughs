<?php

namespace App\Http\Resources;

use App\Http\Resources\CompanyResource;
use App\Http\Resources\GameReleaseResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GameDeveloperResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "desarrollador" => $this->when(
                $this->relationLoaded('company') && $this->company && !$this->isFromApiCompany($request),
                new CompanyResource($this->company)
            ),
            "lanzamiento" => $this->when(
                $this->relationLoaded('gameRelease') && $this->gameRelease && !$this->isFromApiGameRelease($request),
                new GameReleaseResource($this->gameRelease)
            ),
        ];
    }
    private function isFromApiCompany(Request $request): bool
    {
        return strpos($request->getPathInfo(), '/api/company') !== false;
    }
    private function isFromApiGameRelease(Request $request): bool
    {
        return strpos($request->getPathInfo(), '/api/gameRelease') !== false;
    }
}
