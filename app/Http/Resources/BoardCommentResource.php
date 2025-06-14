<?php

namespace App\Http\Resources;

use App\Http\Resources\BoardCommentImageResource;
use App\Http\Resources\BoardResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Crypt;

class BoardCommentResource extends JsonResource
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
            "comentario"    => $this->comment,
            //$this->mergeWhen($this->relationLoaded('boardCommentImages'), BoardCommentImageResource::collection($this->boardCommentImages)), // Hace el merge solo si la relación está cargada
            "imagenes" => $this->when(
                $this->relationLoaded('boardCommentImages'),
                BoardCommentImageResource::collection($this->boardCommentImages),
            ),
            "foro" => $this->when(
                $this->board && !$this->isFromApiBoard($request),
                new BoardResource($this->board)
            ),
        ];
    }
    private function isFromApiBoard(Request $request): bool
    {
        return strpos($request->getPathInfo(), '/api/board') !== false;
    }
}
