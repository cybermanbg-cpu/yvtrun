<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LocationHistory;
use App\Models\Donation;
use App\Models\Volunteer;

class StatsController extends Controller
{
    public function index()
    {
        $totalDistance = LocationHistory::getTotalDistanceFromHistory();
        $totalPoints = LocationHistory::count();
        $lastLocation = LocationHistory::latest('recorded_at')->first();
        $todayPoints = LocationHistory::whereDate('recorded_at', today())->count();
        
        $totalRaised = Donation::getTotalRaised();
        $volunteersCount = Volunteer::confirmed()->count();
        
        return view('admin.stats', compact(
            'totalDistance', 'totalPoints', 'lastLocation', 
            'todayPoints', 'totalRaised', 'volunteersCount'
        ));
    }
}