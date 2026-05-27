<?php

namespace App\Http\Controllers;

use App\Models\Run;
use App\Models\Checkpoint;
use App\Models\Donation;
use App\Models\Volunteer;
use App\Models\YouTubeVideo; // ДОБАВИ ТОВА

class RunController extends Controller
{
    public function index()
    {
        $run = Run::first();
        $checkpoints = Checkpoint::orderBy('order_position')->get();
        
        $totalRaised = Donation::getTotalRaised();
        $donorsCount = Donation::getDonorsCount();
        $goalAmount = 10000;
        $percentage = ($totalRaised / $goalAmount) * 100;
        
        $volunteersCount = Volunteer::confirmed()->count();
        $volunteersByRole = Volunteer::getGroupedByRole();
        $recentVolunteers = Volunteer::confirmed()->orderBy('created_at', 'desc')->limit(5)->get();
        
        $currentLat = $run->current_lat ?? 42.4833;
        $currentLng = $run->current_lng ?? 26.5000;
        $currentDistance = $run->distance_covered_km ?? 0;
        
        // Вземи видеата
        $liveVideo = YouTubeVideo::where('is_live', true)->where('is_active', true)->first();
        $pastVideos = YouTubeVideo::where('is_live', false)->where('is_active', true)->orderBy('created_at', 'desc')->get();
        
        return view('map', compact(
            'checkpoints', 'totalRaised', 'donorsCount', 'goalAmount', 'percentage',
            'volunteersCount', 'volunteersByRole', 'recentVolunteers',
            'currentLat', 'currentLng', 'currentDistance',
            'liveVideo', 'pastVideos'  // ДОБАВИ ТОВА
        ));
    }
}