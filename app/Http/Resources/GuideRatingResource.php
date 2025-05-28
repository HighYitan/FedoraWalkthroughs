<?php

namespace App\Http\Resources;

use App\Http\Resources\GuideResource;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Crypt;

class GuideRatingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => Crypt::encryptString($this->id),
            "puntuacion" => $this->rating,
            "guia" => $this->when(
                $this->relationLoaded('guide') && !$this->isFromApiGuide($request),
                new GuideResource($this->guide)
            ),
            "usuario" => $this->when(
                $this->relationLoaded('user') && !$this->isFromApiUser($request),
                new UserResource($this->user)
            ),
        ];
    }
    private function isFromApiGuide(Request $request): bool
    {
        return strpos($request->getPathInfo(), '/api/guide') !== false;
    }
    private function isFromApiUser(Request $request): bool
    {
        return strpos($request->getPathInfo(), '/api/user') !== false;
    }
}
