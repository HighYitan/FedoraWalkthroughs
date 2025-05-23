<?php

namespace App\Models;

use App\Models\GameRating;
use App\Models\GameRelease;
use App\Models\GameTranslation;
use App\Models\Genre;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $fillable = [
        'slug',
        'featured',
        'image',
        'video',
        'website',
    ];
    public function gameRatings()
    {
        return $this->hasMany(GameRating::class);  // 1:N
    }

    public function gameReleases()
    {
        return $this->hasMany(GameRelease::class);  // 1:N
    }

    public function gameTranslations()
    {
        return $this->hasMany(GameTranslation::class);  // 1:N
    }

    public function genres()
    {
        return $this->belongsToMany(Genre::class);  // 1:N
    }

    // Método para actualizar la puntuación media de un juego
    public function updateAverageRating()
    {
        $average = $this->gameRatings()->avg('rating');
        $this->rating = $average;
        $this->save();
    }
}
