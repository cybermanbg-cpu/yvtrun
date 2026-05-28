<?php

use App\Http\Controllers\Api\DonationStatsController;
use Illuminate\Support\Facades\Route;

Route::get('/donations-stats', [DonationStatsController::class, 'index']);

// Основен маршрут
Route::post('/owntracks', [App\Http\Controllers\Api\OwnTracksController::class, 'publish']);

// За всеки случай, ако OwnTracks добавя /pub
Route::post('/owntracks/pub', [App\Http\Controllers\Api\OwnTracksController::class, 'publish']);

Route::post('/owntracks/test', function (Request $request) {
    \Log::info('TEST OwnTracks received', [
        'all_headers' => $request->headers->all(),
        'payload' => $request->all()
    ]);
    
    return response()->json([]);
});