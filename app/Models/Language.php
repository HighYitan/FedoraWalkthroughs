<?php

namespace App\Models;

use App\Models\Board;
use App\Models\Company;
use App\Models\GameTranslation;
use App\Models\GenreTranslation;
use App\Models\Guide;
use App\Models\NewsLanguage;
use App\Models\RegionTranslation;
use App\Models\UserInterfaceTranslation;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $fillable = [
        'locale',
        'name',
        'flag',
    ];

    protected $guarded = [
        'id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function boards()
    {
        return $this->hasMany(Board::class);  // 1:N
    }

    public function companies()
    {
        return $this->hasMany(Company::class);  // 1:N
    }

    public function gameTranslations()
    {
        return $this->hasMany(GameTranslation::class);  // 1:N
    }

    public function guides()
    {
        return $this->hasMany(Guide::class);  // 1:N
    }

    public function genreTranslations()
    {
        return $this->hasMany(GenreTranslation::class);
    }

    public function newsLanguages()
    {
        return $this->hasMany(NewsLanguage::class);
    }

    public function regionTranslations()
    {
        return $this->hasMany(RegionTranslation::class);
    }

    public function userInterfaceTranslations()
    {
        return $this->hasMany(UserInterfaceTranslation::class);
    }
}
