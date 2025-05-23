<?php

namespace App\Providers;

use App\Models\Game;
use App\Models\Role;
use App\Models\User;
use App\Models\Board;
use App\Models\Genre;
use App\Models\Company;
use App\Models\Language;
use App\Models\Platform;
use App\Models\GameRelease;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Route::bind('role', function ($value) {
            return Role::where('name', $value)->firstOrFail();
        });

        Route::bind('user', function ($value) {
            return User::where('email', $value)->firstOrFail(); // Only search by 'email'
        });

        Route::bind('language', function ($value) {
            return Language::where('locale', $value)->firstOrFail(); // Only search by 'locale'
        });

        Route::bind('genre', function ($value) {
            return Genre::where('slug', $value)->firstOrFail(); // Only search by 'slug'
        });

        Route::bind('platform', function ($value) {
            return Platform::where('name', $value)->firstOrFail(); // Only search by 'name'
        });

        Route::bind('company', function ($value) {
            return Company::where('name', $value)->firstOrFail(); // Only search by 'name'
        });

        Route::bind('game', function ($value) {
            return Game::where('slug', $value)->firstOrFail(); // Only search by 'slug'
        });

        Route::bind('gameRelease', function ($value) {
            try {
                $id = Crypt::decryptString($value);
            } catch (\Exception $e) {
                abort(404, 'ID inválido');
            }
            return GameRelease::findOrFail($id);
        });

        Route::bind('board', function ($value) {
            try {
                $id = Crypt::decryptString($value);
            } catch (\Exception $e) {
                abort(404, 'ID inválido');
            }
            return Board::findOrFail($id);
        });

        RateLimiter::for('api', function ($request) {
            return Limit::perMinute(50); // Limita a 50 peticions per minut
        });
        Route::pattern('id', '[0-9]+'); // El paràmetre 'id' només pot ser numèric
    }
}
