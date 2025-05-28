<?php

namespace App\Http\Resources;

use App\Http\Resources\NewsLanguageResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NewsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "titulo_inicial"    => $this->slug,
            "traducciones"      => NewsLanguageResource::collection($this->newsLanguages),
        ];
    }
}
