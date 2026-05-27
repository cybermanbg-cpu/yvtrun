<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Donation;

class DonationStatsController extends Controller
{
    public function index()
    {
        $totalRaised = Donation::getTotalRaised();
        $goalAmount = 10000; // Целта е 10,000 лв.
        
        return response()->json([
            'success' => true,
            'total_raised' => $totalRaised,
            'total_raised_formatted' => number_format($totalRaised, 0) . ' лв.',
            'donors_count' => Donation::getDonorsCount(),
            'goal_amount' => $goalAmount,
            'percentage' => round(($totalRaised / $goalAmount) * 100, 1),
            'message' => $this->getMotivationalMessage($totalRaised, $goalAmount)
        ]);
    }
    
    private function getMotivationalMessage($totalRaised, $goalAmount)
    {
        $percentage = ($totalRaised / $goalAmount) * 100;
        
        if ($percentage < 25) {
            return '🎯 Направете първата крачка - дарете сега!';
        } elseif ($percentage < 50) {
            return '💪 Продължаваме напред! Вие правите разликата.';
        } elseif ($percentage < 75) {
            return '🚀 Близо сме до целта! Благодарим на всички дарители.';
        } elseif ($percentage < 100) {
            return '🎉 Почти успяхме! Помогнете да достигнем целта.';
        } else {
            return '🏆 ЦЕЛТА Е ПОСТИГНАТА! Безкрайни благодарности!';
        }
    }
}