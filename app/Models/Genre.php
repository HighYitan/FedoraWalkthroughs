<?php

namespace App\Models;

use App\Models\Game;
use App\Models\GenreTranslation;
use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    protected $fillable = ['slug'];

    public function games()
    {
        return $this->belongsToMany(Game::class);  // 1:N
    }

    public function genreTranslations()
    {
        return $this->hasMany(GenreTranslation::class);
    }
}
