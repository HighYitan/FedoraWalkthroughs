<?php

namespace App\Models;

use App\Models\Company;
use App\Models\GameRelease;
use Illuminate\Database\Eloquent\Model;

class GamePublisher extends Model
{
    protected $fillable = [
        'company_id',
        'game_release_id',
    ];
    public function company()
    {
        return $this->belongsTo(Company::class);  // N:1
    }

    public function gameRelease()
    {
        return $this->belongsTo(GameRelease::class);  // N:1
    }
}
