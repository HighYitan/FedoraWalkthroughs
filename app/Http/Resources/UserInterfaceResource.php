<?php

namespace App\Http\Resources;

use App\Http\Resources\UserInterfaceTranslationResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserInterfaceResource extends JsonResource
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
            "traducciones"      => UserInterfaceTranslationResource::collection($this->userInterfaceTranslations),
        ];
    }
}
