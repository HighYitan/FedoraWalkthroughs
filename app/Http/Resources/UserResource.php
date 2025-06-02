<?php

namespace App\Http\Resources;

use App\Http\Resources\BoardCommentResource;
use App\Http\Resources\BoardResource;
use App\Http\Resources\GameRatingResource;
use App\Http\Resources\GuideRatingResource;
use App\Http\Resources\GuideResource;
use App\Http\Resources\RoleResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "nombre"    => $this->name,
            "correo"    => $this->email,
            "baneado"   => $this->banned == "Y" ? "Sí" : "No",
            $this->mergeWhen(
                $this->relationLoaded('role'),
                new RoleResource($this->role)
            ), // Hace el merge solo si la relación está cargada
            "foros" => $this->when(
                $this->relationLoaded('boards') && $this->boards && $this->boards->isNotEmpty() && !$this->isFromApiBoard($request), // Si compruebas la relación cargada después de lo demás, las comprobaciones anteriores lo cargan y lo hace cierto siempre.
                fn () => (BoardResource::collection($this->boards)->toArray($request))
            ),
            "guias" => $this->when(
                $this->relationLoaded('guides') && $this->guides && $this->guides->isNotEmpty() && !$this->isFromApiGuide($request),
                GuideResource::collection($this->guides),
            ),
            "comentarios_foros" => $this->when(
                $this->relationLoaded('boardComments') && $this->boardComments && $this->boardComments->isNotEmpty(),
                BoardCommentResource::collection($this->boardComments),
            ),
            "puntuaciones_juegos" => $this->when(
                $this->relationLoaded('gameRatings') && $this->gameRatings && $this->gameRatings->isNotEmpty(),
                GameRatingResource::collection($this->gameRatings),
            ),
            "puntuaciones_guias" => $this->when(
                $this->relationLoaded('guideRatings') && $this->guideRatings && $this->guideRatings->isNotEmpty() && !$this->isFromApiGuide($request),
                GuideRatingResource::collection($this->guideRatings),
            ),
        ];
    }
    private function isFromApiBoard(Request $request): bool
    {
        return strpos($request->getPathInfo(), '/api/board') !== false;
    }
    private function isFromApiGuide(Request $request): bool
    {
        return strpos($request->getPathInfo(), '/api/guide') !== false;
    }
}
