<?php

use App\Http\Controllers\Api\DonationStatsController;
use Illuminate\Support\Facades\Route;

Route::get('/donations-stats', [DonationStatsController::class, 'index']);

// Основен маршрут
Route::post('/owntracks', [App\Http\Controllers\Api\OwnTracksController::class, 'publish']);

// За всеки случай, ако OwnTracks добавя /pub
Route::post('/owntracks/pub', [App\Http\Controllers\Api\OwnTracksController::class, 'publish']);