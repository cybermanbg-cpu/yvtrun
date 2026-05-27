<?php

namespace App\Http\Controllers;

use App\Models\Run;
use App\Models\Checkpoint;
use App\Models\Donation;

class RunController extends Controller
{
    public function index()
    {
        $run = Run::first();
        $checkpoints = Checkpoint::orderBy('order_position')->get();
        
        // Вземаме данните за даренията
        $totalRaised = Donation::getTotalRaised();
        $donorsCount = Donation::getDonorsCount();
        $goalAmount = 10000; // Цел: 10,000 лв.
        $percentage = ($totalRaised / $goalAmount) * 100;
        
        return view('map', compact('run', 'checkpoints', 'totalRaised', 'donorsCount', 'goalAmount', 'percentage'));
    }
}