<?php

namespace App\Models;

use App\Models\BoardComment;
use Illuminate\Database\Eloquent\Model;

class BoardCommentImage extends Model
{
    public function boardComment()
    {
        return $this->belongsTo(BoardComment::class);  // N:1
    }
}
