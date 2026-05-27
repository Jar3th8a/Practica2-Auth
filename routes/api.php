<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController; // <-- Revisa que tenga su importación

// Asegúrate de que no esté envuelta en un middleware que pida token para entrar
Route::post('/login', [AuthController::class, 'login']);