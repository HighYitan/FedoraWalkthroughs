<?php

namespace App\Models;

use App\Models\GameRelease;
use App\Models\RegionTranslation;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    public function gameReleases()
    {
        return $this->hasMany(GameRelease::class);  // 1:N
    }

    public function regionTranslations()
    {
        return $this->hasMany(RegionTranslation::class);  // 1:N
    }
}
