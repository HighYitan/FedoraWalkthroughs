<?php

namespace App\Models;

use App\Models\NewsLanguage;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    public function newsLanguages()
    {
        return $this->hasMany(NewsLanguage::class);
    }
}
