<?php

namespace App\Models;

use App\Models\GameDeveloper;
use App\Models\GamePublisher;
use App\Models\Language;
use App\Models\Platform;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'name',
        'foundation_year',
        'country_id',
        'website',
        'image',
    ];
    public function gameDevelopers()
    {
        return $this->hasMany(GameDeveloper::class);  // 1:N
    }
    
    public function gamePublishers()
    {
        return $this->hasMany(GamePublisher::class);  // 1:N
    }
    
    public function language()
    {
        return $this->belongsTo(Language::class, 'country_id');
    }

    public function platforms()
    {
        return $this->hasMany(Platform::class);  // 1:N
    }
}
