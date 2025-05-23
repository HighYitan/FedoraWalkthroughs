<?php

namespace App\Models;

use App\Models\BoardComment;
use App\Models\GameRelease;
use App\Models\Language;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
    protected $fillable = [
        'title',
        'description',
        'game_release_id',
        'language_id',
        'user_id'
    ];

    public function boardComments()
    {
        return $this->hasMany(BoardComment::class);  // 1:N
    }

    public function gameRelease()
    {
        return $this->belongsTo(GameRelease::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
