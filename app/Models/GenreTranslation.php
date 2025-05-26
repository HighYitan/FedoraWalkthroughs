<?php

namespace App\Models;

use App\Models\Genre;
use App\Models\Language;
use Illuminate\Database\Eloquent\Model;

class GenreTranslation extends Model
{
    protected $fillable = [
        'name',
        'description',
        'genre_id',
        'language_id',
    ];
    public function genre()
    {
        return $this->belongsTo(Genre::class);  // N:1
    }

    public function language()
    {
        return $this->belongsTo(Language::class);  // N:1
    }
}
