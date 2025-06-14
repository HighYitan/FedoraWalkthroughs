<?php

namespace App\Http\Resources;

use App\Http\Resources\CompanyResource;
use App\Http\Resources\GameReleaseResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PlatformResource extends JsonResource
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
            "lanzamiento"   => $this->release_year,
            "imagen"        => $this->image,
            "desarrollador"  => $this->when(
                !$this->isFromApiCompany($request) && !$this->isFromApiGameRelease($request) && !$this->isFromApiUser($request),
                new CompanyResource($this->company)
            ),
            "lanzamientos" => $this->when(
                $this->relationLoaded('gameReleases') && $this->gameReleases && $this->gameReleases->isNotEmpty() && !$this->isFromApiGameRelease($request) && !$this->isFromApiUser($request),
                GameReleaseResource::collection($this->gameReleases)
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
    private function isFromApiUser(Request $request): bool
    {
        return strpos($request->getPathInfo(), '/api/user') !== false;
    }
}
