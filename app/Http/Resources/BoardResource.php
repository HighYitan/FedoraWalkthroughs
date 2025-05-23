<?php

namespace App\Http\Resources;

use App\Http\Resources\BoardCommentResource;
use App\Http\Resources\GameReleaseResource;
use App\Http\Resources\LanguageResource;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Crypt;

class BoardResource extends JsonResource
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
            "titulo"        => $this->title,
            "descripcion"   => $this->description,
            "idioma"        => new LanguageResource($this->language),
            "autor"   => $this->when(
                $this->relationLoaded('user') && $this->user && !$this->isFromApiUser($request),
                new UserResource($this->user)
            ),
            // Quizá habría que meter una condición para que no se muestre desde game/gamerelease api
            //$this->mergeWhen($this->relationLoaded('gameRelease'), new GameReleaseResource($this->gameRelease)),
            // Quizá habría que meter una condición para que no se muestre desde game/gamerelease api
            "lanzamiento_videojuego"    => new GameReleaseResource($this->gameRelease),
            //$this->mergeWhen($this->relationLoaded('boardComments'), BoardCommentResource::collection($this->boardComments)), // Hace el merge solo si la relación está cargada
            "comentarios"   => $this->when(
                $this->relationLoaded('boardComments') && $this->boardComments && $this->boardComments->isNotEmpty() && !$this->isFromApiUser($request),
                BoardCommentResource::collection($this->boardComments),
            ),
        ];
    }
    private function isFromApiUser(Request $request): bool // Comprueba si la ruta viene de la API de User y evita duplicados en la respuesta al llamar desde User
    {
        return strpos($request->getPathInfo(), '/api/user') !== false; // Si la ruta contiene '/api/user' devuelve un valor que no es false (La posición del substring en la cadena) por eso es necesario el !== false
    }
}
