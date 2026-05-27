<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DonationStatsController;

Route::get('/donations-stats', [DonationStatsController::class, 'index']);