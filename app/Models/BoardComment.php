<?php

namespace App\Models;

use App\Models\Board;
use App\Models\BoardCommentImage;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class BoardComment extends Model
{
    protected $fillable = [
        'board_id',
        'user_id',
        'content',
        'created_at',
        'updated_at'
    ];

    public function board()
    {
        return $this->belongsTo(Board::class);
    }

    public function boardCommentImages()
    {
        return $this->hasMany(BoardCommentImage::class);  // 1:N
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
