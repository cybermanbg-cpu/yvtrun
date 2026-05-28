<?php

use App\Http\Controllers\Api\DonationStatsController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

// === DONATION STATS ===
Route::get('/donations-stats', [DonationStatsController::class, 'index']);

// === OWNTRACKS ROUTES (без CSRF защита) ===
Route::post('/owntracks', [App\Http\Controllers\Api\OwnTracksController::class, 'publish'])
     ->withoutMiddleware('csrf');

Route::post('/owntracks/pub', [App\Http\Controllers\Api\OwnTracksController::class, 'publish'])
     ->withoutMiddleware('csrf');

// Тестов маршрут
Route::post('/owntracks/test', function (Request $request) {
    \Log::info('=== TEST OwnTracks received ===', [
        'ip' => $request->ip(),
        'headers' => $request->headers->all(),
        'payload' => $request->all()
    ]);
    
    return response()->json([]);
})->withoutMiddleware('csrf');
