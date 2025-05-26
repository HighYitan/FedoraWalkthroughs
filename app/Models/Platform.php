<?php

namespace App\Models;

use App\Models\Company;
use App\Models\GameRelease;
use Illuminate\Database\Eloquent\Model;

class Platform extends Model
{
    protected $fillable = [
        'name',
        'release_year',
        'image',
        'company_id'
    ];
    public function company()
    {
        return $this->belongsTo(Company::class);  // N:1
    }

    public function gameReleases()
    {
        return $this->belongsToMany(GameRelease::class);  // 1:N
    }
}
