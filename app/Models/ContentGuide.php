<?php

namespace App\Models;

use App\Models\Guide;
use Illuminate\Database\Eloquent\Model;

class ContentGuide extends Model
{
    protected $fillable = [
        'name',
        'content',
        'guide_id'
    ];
    public function guide()
    {
        return $this->belongsTo(Guide::class);  // N:1
    }
}
