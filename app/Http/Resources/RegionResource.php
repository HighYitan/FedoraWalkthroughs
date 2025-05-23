<?php

namespace App\Http\Resources;

use App\Http\Resources\RegionTranslationResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RegionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "nombre_inicial" => $this->slug,
            //"region"        => new RegionTranslationResource($this->region), //Array
            //$this->mergeWhen($this->relationLoaded('regionTranslations'), new RegionTranslationResource($this->regionTranslations)), //Merge
            "traducciones"   => $this->when(
                $this->regionTranslations && $this->regionTranslations->isNotEmpty(),
                regionTranslationResource::collection($this->regionTranslations),
            ),
        ];
    }
}
