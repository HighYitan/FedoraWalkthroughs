<?php

namespace App\Http\Resources;

use App\Http\Resources\BoardResource;
use App\Http\Resources\GameDeveloperResource;
use App\Http\Resources\GamePublisherResource;
use App\Http\Resources\GameResource;
use App\Http\Resources\GuideResource;
use App\Http\Resources\PlatformResource;
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
            "videojuego"    => $this->when(
                $this->relationLoaded('game') && $this->game && !$this->isFromApiGame($request),
                new GameResource($this->game)
            ),
            "region" => new RegionResource($this->region),
            "plataformas" => $this->when(
                $this->relationLoaded('platforms') && $this->platforms && $this->platforms->isNotEmpty() && !$this->isFromApiPlatform($request),
                PlatformResource::collection($this->platforms)
            ),
            "desarrolladores" => $this->when(
                $this->relationLoaded('gameDevelopers') && $this->gameDevelopers && $this->gameDevelopers->isNotEmpty(),
                GameDeveloperResource::collection($this->gameDevelopers)
            ),
            "distribuidores" => $this->when(
                $this->relationLoaded('gamePublishers') && $this->gamePublishers && $this->gamePublishers->isNotEmpty(),
                GamePublisherResource::collection($this->gamePublishers)
            ),
            "guias" => $this->when(
                $this->relationLoaded('guides') && $this->guides && $this->guides->isNotEmpty() && !$this->isFromApiGuide($request),
                GuideResource::collection($this->guides)
            ),
            "temas" => $this->when(
                $this->relationLoaded('boards') && $this->boards && $this->boards->isNotEmpty() && !$this->isFromApiBoard($request),
                BoardResource::collection($this->boards)
            ),
        ];
    }
    private function isFromApiBoard(Request $request): bool
    {
        return strpos($request->getPathInfo(), '/api/board') !== false;
    }
    private function isFromApiGame(Request $request): bool
    {
        return preg_match('#^/api/game(/|$)#', $request->getPathInfo()) === 1;
    }
    private function isFromApiGuide(Request $request): bool
    {
        return strpos($request->getPathInfo(), '/api/guide') !== false;
    }
    private function isFromApiPlatform(Request $request): bool
    {
        return strpos($request->getPathInfo(), '/api/platform') !== false;
    }
}
