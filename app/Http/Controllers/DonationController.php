<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use Illuminate\Http\Request;

class DonationController extends Controller
{
    public function index()
    {
        $totalRaised = Donation::getTotalRaised();
        $donorsCount = Donation::getDonorsCount();
        $topDonors = Donation::getTopDonors(5);
        
        return view('donations.index', compact('totalRaised', 'donorsCount', 'topDonors'));
    }
    
    public function store(Request $request)
    {
        // Валидация
        $validated = $request->validate([
            'amount' => 'required|numeric|min:1|max:10000',
            'email' => 'required|email|max:255',
            'donor_name' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:500',
            'message' => 'nullable|string|max:500',
            'is_anonymous' => 'nullable|boolean'
        ]);
        
        // Ако е анонимно, името става "Анонимен дарител"
        if ($request->has('is_anonymous') && $request->is_anonymous == 1) {
            $validated['donor_name'] = 'Анонимен дарител';
        }
        
        // Ако няма име и не е анонимно, използвай email-а
        if (empty($validated['donor_name']) && (!$request->has('is_anonymous') || $request->is_anonymous != 1)) {
            $validated['donor_name'] = explode('@', $validated['email'])[0];
        }
        
        $validated['status'] = 'completed';
        
        // Създаване на дарение
        $donation = Donation::create($validated);
        
        return redirect()->route('donations.thankyou', $donation)
            ->with('success', 'Благодарим ви за дарението!');
    }
    
    public function thankyou(Donation $donation)
    {
        return view('donations.thankyou', compact('donation'));
    }
}