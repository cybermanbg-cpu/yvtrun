<?php

namespace App\Http\Controllers;

use App\Models\Volunteer;
use Illuminate\Http\Request;

class VolunteerController extends Controller
{
    // Показва формата
    public function index()
    {
        $roles = Volunteer::getRoles();
        $timeSlots = [
            '06:00-10:00' => '06:00 - 10:00 сутринта',
            '10:00-14:00' => '10:00 - 14:00 (обед)',
            '14:00-18:00' => '14:00 - 18:00 (следобед)',
            '18:00-22:00' => '18:00 - 22:00 (вечер)',
            '22:00-02:00' => '22:00 - 02:00 (нощна смяна)'
        ];
        
        $checkpoints = \App\Models\Checkpoint::orderBy('distance_km')->get();
        
        return view('volunteers.index', compact('roles', 'timeSlots', 'checkpoints'));
    }
    
    // Записва доброволеца
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string|in:' . implode(',', array_keys(Volunteer::getRoles())),
            'phone' => 'required|string|max:20',
            'time_slot' => 'required|string|max:50',
            'checkpoint_location' => 'nullable|string|max:255',
            'additional_info' => 'nullable|string|max:500'
        ]);
        
        $validated['confirmed'] = false; // Изчаква потвърждение
        
        $volunteer = Volunteer::create($validated);
        
        return redirect()->route('volunteers.thankyou')
            ->with('success', 'Благодарим ви, че се регистрирахте като доброволец! Ще се свържем с вас за потвърждение.');
    }
    
    public function thankyou()
    {
        return view('volunteers.thankyou');
    }
}