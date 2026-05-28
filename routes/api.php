<?php

use App\Http\Controllers\Api\DonationStatsController;
use Illuminate\Support\Facades\Route;

Route::get('/donations-stats', [DonationStatsController::class, 'index']);