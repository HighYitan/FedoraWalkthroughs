<?php

namespace App\Models;

use App\Models\Board;
use App\Models\Game;
use App\Models\GameDeveloper;
use App\Models\GamePublisher;
use App\Models\Guide;
use App\Models\Platform;
use App\Models\Region;
use Illuminate\Database\Eloquent\Model;

class GameRelease extends Model
{
    protected $fillable = [
        'name',
        'release_date',
        'game_id',
        'region_id'
    ];
    public function boards()
    {
        return $this->hasMany(Board::class);  // 1:N
    }

    public function gameDevelopers()
    {
        return $this->hasMany(GameDeveloper::class);  // 1:N
    }
    
    public function gamePublishers()
    {
        return $this->hasMany(GamePublisher::class);  // 1:N
    }

    public function game()
    {
        return $this->belongsTo(Game::class);  // N:1
    }

    public function guides()
    {
        return $this->hasMany(Guide::class);  // 1:N
    }

    public function platforms()
    {
        return $this->belongsToMany(Platform::class);  // 1:N
    }

    public function region()
    {
        return $this->belongsTo(Region::class);  // N:1
    }
}
