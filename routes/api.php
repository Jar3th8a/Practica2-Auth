<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController; // <-- IMPORTANTE: Para que lea tu AuthController
use App\Http\Controllers\ProductoController; // <-- IMPORTANTE: Para que lea tu ProductoController

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// 4.3 Definir las rutas públicas de autenticación
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);

// Rutas protegidas (El usuario debe estar autenticado con Sanctum)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me',      [AuthController::class, 'me']);
    
    // Tu recurso completo de productos (CRUD: index, store, show, update, destroy)
    Route::apiResource('productos', ProductoController::class);
});