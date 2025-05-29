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
use App\Http\Controllers\Api\NewsController;
use App\Http\Controllers\Api\PlatformController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\UserInterfaceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']); // Registre d'usuaris
Route::post('/login', [AuthController::class, 'login']); // Iniciar sessió

Route::middleware('auth:sanctum')->group(function () { //Si ApiKeyMiddleware està activat no funcionaría así que hay que poner un if() en ese middleware concreto.
    Route::get("role", [RoleController::class, 'index']); // Llistar tots els rols
    Route::apiResource('user', UserController::class)->except(['store']);
    Route::apiResource('genre', GenreController::class);
    Route::apiResource('company', CompanyController::class);
    Route::apiResource('platform', PlatformController::class);
    Route::apiResource('game', GameController::class)->names([
        'index' => 'api.game.index',
        'show' => 'api.game.show',
        'store' => 'api.game.store',
        'update' => 'api.game.update',
        'destroy' => 'api.game.destroy',
        'create' => 'api.game.create',
        'edit' => 'api.game.edit',
    ]);
    Route::apiResource('gameRelease', GameReleaseController::class);
    Route::apiResource('gameRating', GameRatingController::class)->except(['index', 'show']);
    Route::apiResource('guide', GuideController::class);
    Route::apiResource('content', ContentGuideController::class)->except(['index', 'show']);
    Route::apiResource('guideRating', GuideRatingController::class)->except(['index', 'show']);
    Route::apiResource('board', BoardController::class);
    Route::apiResource('news', NewsController::class); // Llistar notícies
    Route::apiResource('userInterface', UserInterfaceController::class)->except(['store', 'update', 'destroy']);
    
    Route::post('/logout', [AuthController::class, 'logout']); // Tancar sessió (Eliminar token)
});

Route::middleware(['ApiKeyMiddleware'])->group(function () {
    Route::get("role", [RoleController::class, 'index']); // Llistar tots els rols
    Route::apiResource('user', UserController::class)->except(['store']);
    Route::apiResource('genre', GenreController::class);
    Route::apiResource('company', CompanyController::class);
    Route::apiResource('platform', PlatformController::class);
    Route::apiResource('game', GameController::class)->names([
        'index' => 'api.game.index',
        'show' => 'api.game.show',
        'store' => 'api.game.store',
        'update' => 'api.game.update',
        'destroy' => 'api.game.destroy',
        'create' => 'api.game.create',
        'edit' => 'api.game.edit',
    ]);
    Route::apiResource('gameRelease', GameReleaseController::class);
    Route::apiResource('gameRating', GameRatingController::class)->except(['index', 'show']);
    Route::apiResource('guide', GuideController::class);
    Route::apiResource('content', ContentGuideController::class)->except(['index', 'show']);
    Route::apiResource('guideRating', GuideRatingController::class)->except(['index', 'show']);
    Route::apiResource('board', BoardController::class);
    Route::apiResource('news', NewsController::class); // Llistar notícies
    Route::apiResource('userInterface', UserInterfaceController::class)->except(['store', 'update', 'destroy']);
});