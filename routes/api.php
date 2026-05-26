<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// 1. Agregamos la importación del controlador aquí arriba
use App\Http\Controllers\ProductoController; 

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// 2. Agregamos tu nueva ruta de la API aquí abajo
Route::apiResource('productos', ProductoController::class);