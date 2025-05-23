<?php

namespace App\Models;

use App\Models\Game;
use App\Models\Language;
use Illuminate\Database\Eloquent\Model;

class RegionTranslation extends Model
{
    public function language()
    {
        return $this->belongsTo(Language::class);  // N:1
    }

    public function region()
    {
        return $this->belongsTo(Game::class);  // N:1
    }
}
