<?php

namespace App\Models;

use App\Models\Language;
use App\Models\News;
use Illuminate\Database\Eloquent\Model;

class NewsLanguage extends Model
{
    public function language()
    {
        return $this->belongsTo(Language::class);  // N:1
    }

    public function news()
    {
        return $this->belongsTo(News::class);  // N:1
    }
}
