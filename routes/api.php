<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MisurazioneController;
use App\Http\Controllers\StrumentoController;

// Rotte pubbliche
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Rotte protette
Route::middleware('auth:sanctum')->group(function () {
    // Auth
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
    
    // Misurazioni
    Route::apiResource('misurazioni', MisurazioneController::class);
    
    // Strumenti
    Route::apiResource('strumenti', StrumentoController::class);
});