<?php

namespace App\Models;

use App\Models\Game;
use App\Models\Language;
use Illuminate\Database\Eloquent\Model;

class GameTranslation extends Model
{
    protected $fillable = [
        'description',
        'game_id',
        'language_id',
    ];
    public function game()
    {
        return $this->belongsTo(Game::class);  // N:1
    }

    public function language()
    {
        return $this->belongsTo(Language::class);  // N:1
    }
}
