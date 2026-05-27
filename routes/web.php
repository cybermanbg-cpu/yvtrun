<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\RunController;
use App\Http\Controllers\VolunteerController;
use App\Models\Run;

// Главна страница
Route::get('/', [RunController::class, 'index'])->name('home');

// API за текущата позиция на бегача
Route::get('/current-runner-position', function() {
    $run = Run::first();
    return response()->json([
        'lat' => (float) $run->current_lat,
        'lng' => (float) $run->current_lng,
        'distance' => (float) $run->distance_covered_km
    ]);
});

// API за обновяване на позицията
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

// Панел на бегача - GET (показва формата или панела)
Route::get('/runner-panel', function () {
    // Проверка дали вече е влязъл
    if (session()->has('runner_panel_authenticated')) {
        return view('runner.panel');
    }
    return view('runner.login');
})->name('runner.panel');

// Панел на бегача - POST (обработка на паролата)
Route::post('/runner-panel', function () {
    $password = request()->input('password');
    $correctPassword = env('RUNNER_PANEL_PASSWORD', 'Yambol2025');
    
    if ($password === $correctPassword) {
        session()->put('runner_panel_authenticated', true);
        return redirect()->route('runner.panel');
    }
    
    return back()->withErrors(['password' => 'Невалидна парола!']);
});

// Маршрут за изход от панела
Route::post('/runner-panel/logout', function () {
    session()->forget('runner_panel_authenticated');
    return redirect('/runner-panel');
})->name('runner.panel.logout');

// Запазване на следата
Route::post('/save-runner-trail', function() {
    $data = request()->validate(['trail' => 'required|array']);
    $run = Run::first();
    $run->update(['trail_points' => json_encode($data['trail'])]);
    return response()->json(['success' => true]);
});

// Вземане на следата
Route::get('/get-runner-trail', function() {
    $run = Run::first();
    return response()->json(['trail' => json_decode($run->trail_points ?? '[]', true)]);
});