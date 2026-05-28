<?php

use App\Http\Controllers\Api\DonationStatsController;
use App\Http\Controllers\Api\OwnTracksController;
use Illuminate\Support\Facades\Route;

Route::get('/donations-stats', [DonationStatsController::class, 'index']);

Route::post('/owntracks/pub', [OwnTracksController::class, 'publish']);