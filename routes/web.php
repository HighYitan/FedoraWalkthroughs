<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ContentGuideController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\GameReleaseController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\GuideController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PlatformController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('game', GameController::class);
    Route::resource('gameRelease', GameReleaseController::class);
    Route::resource('guide', GuideController::class);
    Route::resource('content', ContentGuideController::class)->except(['index', 'show']);
    Route::resource('user', UserController::class)->except(['store', 'create']);
    Route::resource('news', NewsController::class);
    Route::resource('company', CompanyController::class);
    Route::resource('platform', PlatformController::class);
    Route::resource('genre', GenreController::class);
});

require __DIR__.'/auth.php';
