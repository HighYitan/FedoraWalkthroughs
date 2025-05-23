<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Board;
use App\Models\BoardComment;
use App\Models\GameRating;
use App\Models\Guide;
use App\Models\GuideRating;
use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'banned',
        'role_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    // Relacions entre taules:
    public function boards()
    {
        return $this->hasMany(Board::class);  // 1:N
    }
    public function boardComments()
    {
        return $this->hasMany(BoardComment::class);  // 1:N
    }
    public function gameRatings()
    {
        return $this->hasMany(GameRating::class);  // 1:N
    }
    public function guides()
    {
        return $this->hasMany(Guide::class);  // 1:N
    }
    public function guideRatings()
    {
        return $this->hasMany(GuideRating::class);  // 1:N
    }
    public function role()
    {
        return $this->belongsTo(Role::class);  // N:1
    }
}
