<?php

namespace App\Models;

use App\Models\ContentGuide;
use App\Models\GameRelease;
use App\Models\GuideRating;
use App\Models\Language;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Guide extends Model
{
    public function contentGuides()
    {
        return $this->hasMany(ContentGuide::class);  // 1:N
    }

    public function gameRelease()
    {
        return $this->belongsTo(GameRelease::class);  // N:1
    }

    public function guideRatings()
    {
        return $this->hasMany(GuideRating::class);  // 1:N
    }

    public function language()
    {
        return $this->belongsTo(Language::class);  // N:1
    }

    public function user()
    {
        return $this->belongsTo(User::class);  // N:1
    }

    // Método para actualizar la puntuación media de una guía
    public function updateAverageRating()
    {
        $average = $this->guideRatings()->avg('rating');
        $this->rating = $average;
        $this->save();
    }
}
