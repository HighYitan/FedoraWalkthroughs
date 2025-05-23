<?php

namespace App\Models;

use App\Models\UserInterfaceTranslation;
use Illuminate\Database\Eloquent\Model;

class UserInterface extends Model
{
    public function userInterfaceTranslations()
    {
        return $this->hasMany(UserInterfaceTranslation::class);
    }
}
