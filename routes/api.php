<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BoardController;
use App\Http\Controllers\Api\GameController;
use App\Http\Controllers\Api\GenreController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;







/*Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');*/

Route::post('/register', [AuthController::class, 'register']); // Registre d'usuaris
Route::post('/login', [AuthController::class, 'login']); // Iniciar sessió

Route::middleware('auth:sanctum')->group(function () { //Si ApiKeyMiddleware està activat no funcionaría así que hay que poner un if() en ese middleware concreto.
    Route::get("role", [RoleController::class, 'index']); // Llistar tots els rols
    Route::apiResource('user', UserController::class)->except(['store']);
    Route::get("genre", [GenreController::class, 'index']); // Llistar tots els gèneres
    Route::get("genre/{genre}", [GenreController::class, 'show']); // Mostrar un gènere concret
    Route::apiResource('game', GameController::class);
    Route::apiResource('board', BoardController::class);
    
    Route::post('/logout', [AuthController::class, 'logout']); // Tancar sessió (Eliminar token)
});

Route::middleware(['ApiKeyMiddleware'])->group(function () {
    Route::get("role", [RoleController::class, 'index']); // Llistar tots els rols
    Route::apiResource('user', UserController::class)->except(['store']);
});