<?php

namespace App\Models;

use App\Models\Guide;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class GuideRating extends Model
{
    protected $fillable = [
        'rating',
        'guide_id',
        'user_id'
    ];
    public function guide()
    {
        return $this->belongsTo(Guide::class);  // N:1
    }

    public function user()
    {
        return $this->belongsTo(User::class);  // N:1
    }
}
