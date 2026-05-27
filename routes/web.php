<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DonationStatsController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\RunController;
use App\Http\Controllers\VolunteerController;
use App\Models\Run;

Route::get('/', [RunController::class, 'index'])->name('home');

// API маршрут
Route::get('/donations-stats', [DonationStatsController::class, 'index']);

// Маршрут за текущата позиция (само веднъж)
Route::get('/current-runner-position', function() {
    $run = Run::first();
    return response()->json([
        'lat' => (float) $run->current_lat,
        'lng' => (float) $run->current_lng,
        'distance' => (float) $run->distance_covered_km
    ]);
});

// Маршрут за обновяване на позицията
Route::post('/update-runner-location', function() {
    $data = request()->validate([
        'lat' => 'required|numeric',
        'lng' => 'required|numeric',
        'distance' => 'required|numeric'
    ]);
    
    $run = Run::first();
    $run->update([
        'current_lat' => $data['lat'],
        'current_lng' => $data['lng'],
        'distance_covered_km' => $data['distance']
    ]);
    
    return response()->json(['success' => true]);
});

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

// Бегач панел (прост HTML/JS без Livewire)
Route::get('/simple-runner', function () {
    return view('simple-runner');
})->name('simple.runner');