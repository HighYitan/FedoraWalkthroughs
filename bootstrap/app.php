<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Middleware\CheckRoleAdmin;
use App\Http\Middleware\ApiKeyMiddleware;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting( // Rutas presentes en 'web.php' y 'api.php'
        using: function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));
            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        },
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Registrar middleware personalizado
        $middleware->alias([
            'CheckRoleAdmin' => \App\Http\Middleware\CheckRoleAdmin::class, // Middleware personalizado para rol de Administrador
            'ApiKeyMiddleware' => \App\Http\Middleware\ApiKeyMiddleware::class, // Middleware personalitzat que maneja API Key y Token sanctum
        ]);
        // Aplicar middleware específico para API
        $middleware->api("throttle:api"); // Limitar peticiones de API
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Manejar excepciones para las rutas de API
        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'message' => 'No se encontraron elementos.'
                ], 404);
            }
        });
    })->create();
