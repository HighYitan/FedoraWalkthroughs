<?php

namespace App\Models;

use App\Models\Language;
use App\Models\UserInterface;
use Illuminate\Database\Eloquent\Model;

class UserInterfaceTranslation extends Model
{
    public function language()
    {
        return $this->belongsTo(Language::class);  // N:1
    }
    
    public function userInterface()
    {
        return $this->belongsTo(UserInterface::class);  // N:1
    }
}
