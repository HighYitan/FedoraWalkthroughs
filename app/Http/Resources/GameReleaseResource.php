<?php

namespace App\Http\Resources;

use App\Http\Resources\BoardCommentsResource;
use App\Http\Resources\GameResource;
use App\Http\Resources\RegionResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Crypt;

class GameReleaseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"            => Crypt::encryptString($this->id),
            "nombre"        => $this->name,
            "lanzamiento"   => $this->release_date,
            "region"        => new RegionResource($this->region),
            "videojuego"   => $this->when(
                $this->relationLoaded('game') && $this->game && !$this->isFromApiGame($request),
                new GameResource($this->game)
            ),
        ];
    }
    private function isFromApiGame(Request $request): bool
    {
        return strpos($request->getPathInfo(), '/api/game') !== false;
    }
}
