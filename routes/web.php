<?php

use Illuminate\Support\Facades\Route;

// Blocca tutte le richieste web
Route::any('/{any}', function () {
    return response()->json([
        'message' => 'API only. Access via /api endpoints.'
    ], 404);
})->where('any', '.*');