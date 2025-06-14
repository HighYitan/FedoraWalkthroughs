<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BoardController;
use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\ContentGuideController;
use App\Http\Controllers\Api\GameController;
use App\Http\Controllers\Api\GameRatingController;
use App\Http\Controllers\Api\GameReleaseController;
use App\Http\Controllers\Api\GenreController;
use App\Http\Controllers\Api\GuideController;
use App\Http\Controllers\Api\GuideRatingController;
use App\Http\Controllers\Api\LanguageController;
use App\Http\Controllers\Api\NewsController;
use App\Http\Controllers\Api\PlatformController;
use App\Http\Controllers\Api\RegionController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\UserInterfaceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::post('/register', [AuthController::class, 'register']); // Registre d'usuaris
Route::post('/login', [AuthController::class, 'login']); // Iniciar sessió

Route::middleware('auth:sanctum')->group(function () { //Si ApiKeyMiddleware està activat no funcionaría así que hay que poner un if() en ese middleware concreto.
    Route::get("role", [RoleController::class, 'index']); // Llistar tots els rols
    Route::apiResource('user', UserController::class)->except(['store'])->names([
        'index'     => 'api.user.index',
        'show'      => 'api.user.show',
        'update'    => 'api.user.update',
        'destroy'   => 'api.user.destroy',
    ]);
    Route::apiResource('language', LanguageController::class)->except(['store', 'update', 'destroy']);
    Route::apiResource('region', RegionController::class);
    Route::apiResource('genre', GenreController::class)->names([
        'index'     => 'api.genre.index',
        'show'      => 'api.genre.show',
        'store'     => 'api.genre.store',
        'update'    => 'api.genre.update',
        'destroy'   => 'api.genre.destroy',
    ]);
    Route::apiResource('company', CompanyController::class)->names([
        'index'     => 'api.company.index',
        'show'      => 'api.company.show',
        'store'     => 'api.company.store',
        'update'    => 'api.company.update',
        'destroy'   => 'api.company.destroy',
    ]);
    Route::apiResource('platform', PlatformController::class)->names([
        'index'     => 'api.platform.index',
        'show'      => 'api.platform.show',
        'store'     => 'api.platform.store',
        'update'    => 'api.platform.update',
        'destroy'   => 'api.platform.destroy',
    ]);
    Route::apiResource('game', GameController::class)->names([
        'index'     => 'api.game.index',
        'show'      => 'api.game.show',
        'store'     => 'api.game.store',
        'update'    => 'api.game.update',
        'destroy'   => 'api.game.destroy',
    ]);
    Route::apiResource('gameRelease', GameReleaseController::class)->names([
        'index'     => 'api.gameRelease.index',
        'show'      => 'api.gameRelease.show',
        'store'     => 'api.gameRelease.store',
        'update'    => 'api.gameRelease.update',
        'destroy'   => 'api.gameRelease.destroy',
    ]);
    Route::apiResource('gameRating', GameRatingController::class)->except(['index', 'show']);
    Route::apiResource('guide', GuideController::class)->names([
        'index'     => 'api.guide.index',
        'show'      => 'api.guide.show',
        'store'     => 'api.guide.store',
        'update'    => 'api.guide.update',
        'destroy'   => 'api.guide.destroy',
    ]);
    Route::apiResource('content', ContentGuideController::class)->except(['index', 'show'])->names([
        'store'     => 'api.content.store',
        'update'    => 'api.content.update',
        'destroy'   => 'api.content.destroy',
    ]);
    Route::apiResource('guideRating', GuideRatingController::class)->except(['index', 'show']);
    Route::apiResource('board', BoardController::class);
    Route::apiResource('news', NewsController::class)->names([
        'index'     => 'api.news.index',
        'show'      => 'api.news.show',
        'store'     => 'api.news.store',
        'update'    => 'api.news.update',
        'destroy'   => 'api.news.destroy',
    ]); // Llistar notícies
    Route::apiResource('userInterface', UserInterfaceController::class)->except(['store', 'update', 'destroy']);
    
    Route::post('/logout', [AuthController::class, 'logout']); // Tancar sessió (Eliminar token)
});

Route::middleware(['ApiKeyMiddleware'])->group(function () {
    Route::get("role", [RoleController::class, 'index']); // Llistar tots els rols
    Route::apiResource('user', UserController::class)->except(['store'])->names([
        'index'     => 'api.user.index',
        'show'      => 'api.user.show',
        'update'    => 'api.user.update',
        'destroy'   => 'api.user.destroy',
    ]);
    Route::apiResource('language', LanguageController::class)->except(['store', 'update', 'destroy']);
    Route::apiResource('genre', GenreController::class)->names([
        'index'     => 'api.genre.index',
        'show'      => 'api.genre.show',
        'store'     => 'api.genre.store',
        'update'    => 'api.genre.update',
        'destroy'   => 'api.genre.destroy',
    ]);
    Route::apiResource('company', CompanyController::class)->names([
        'index'     => 'api.company.index',
        'show'      => 'api.company.show',
        'store'     => 'api.company.store',
        'update'    => 'api.company.update',
        'destroy'   => 'api.company.destroy',
    ]);
    Route::apiResource('platform', PlatformController::class)->names([
        'index'     => 'api.platform.index',
        'show'      => 'api.platform.show',
        'store'     => 'api.platform.store',
        'update'    => 'api.platform.update',
        'destroy'   => 'api.platform.destroy',
    ]);
    Route::apiResource('game', GameController::class)->names([
        'index'     => 'api.game.index',
        'show'      => 'api.game.show',
        'store'     => 'api.game.store',
        'update'    => 'api.game.update',
        'destroy'   => 'api.game.destroy',
    ]);
    Route::apiResource('gameRelease', GameReleaseController::class)->names([
        'index'     => 'api.gameRelease.index',
        'show'      => 'api.gameRelease.show',
        'store'     => 'api.gameRelease.store',
        'update'    => 'api.gameRelease.update',
        'destroy'   => 'api.gameRelease.destroy',
    ]);
    Route::apiResource('gameRating', GameRatingController::class)->except(['index', 'show']);
    Route::apiResource('guide', GuideController::class)->names([
        'index'     => 'api.guide.index',
        'show'      => 'api.guide.show',
        'store'     => 'api.guide.store',
        'update'    => 'api.guide.update',
        'destroy'   => 'api.guide.destroy',
    ]);
    Route::apiResource('content', ContentGuideController::class)->except(['index', 'show'])->names([
        'store'     => 'api.content.store',
        'update'    => 'api.content.update',
        'destroy'   => 'api.content.destroy',
    ]);
    Route::apiResource('guideRating', GuideRatingController::class)->except(['index', 'show']);
    Route::apiResource('board', BoardController::class);
    Route::apiResource('news', NewsController::class)->names([
        'index'     => 'api.news.index',
        'show'      => 'api.news.show',
        'store'     => 'api.news.store',
        'update'    => 'api.news.update',
        'destroy'   => 'api.news.destroy',
    ]); // Llistar notícies
    Route::apiResource('userInterface', UserInterfaceController::class)->except(['store', 'update', 'destroy']);
});