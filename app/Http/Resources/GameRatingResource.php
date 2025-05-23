<?php

namespace App\Http\Resources;

use App\Http\Resources\GameResource;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GameRatingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "puntuacion"    => $this->rating,
            "videojuego" => $this->when(
                $this->relationLoaded('game') && !$this->isFromApiGame($request),
                new GameResource($this->game)
            ),
            "usuario" => $this->when(
                $this->relationLoaded('user') && !$this->isFromApiUser($request),
                new UserResource($this->user)
            ),
        ];
    }
    private function isFromApiGame(Request $request): bool
    {
        return strpos($request->getPathInfo(), '/api/game') !== false;
    }
    private function isFromApiUser(Request $request): bool
    {
        return strpos($request->getPathInfo(), '/api/user') !== false;
    }
}
