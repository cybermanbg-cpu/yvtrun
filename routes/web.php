<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DonationStatsController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\RunController;
use App\Http\Controllers\VolunteerController;

Route::get('/', [RunController::class, 'index'])->name('home');

// API маршрут (без /api префикс)
Route::get('/donations-stats', [DonationStatsController::class, 'index']);

// Дарения
Route::prefix('donations')->name('donations.')->group(function () {
    Route::get('/', [DonationController::class, 'index'])->name('index');
    Route::post('/store', [DonationController::class, 'store'])->name('store');
    Route::get('/thankyou/{donation}', [DonationController::class, 'thankyou'])->name('thankyou');
});

// Доброволци
Route::prefix('volunteers')->name('volunteers.')->group(function () {
    Route::get('/', [VolunteerController::class, 'index'])->name('index');
    Route::post('/store', [VolunteerController::class, 'store'])->name('store');
    Route::get('/thankyou', [VolunteerController::class, 'thankyou'])->name('thankyou');
});

// Админ контрол
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/control', function () {
        return view('admin.control');
    })->name('admin.control');
});