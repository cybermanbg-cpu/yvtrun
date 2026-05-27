<?php

namespace App\Livewire;

use App\Models\Run;
use Livewire\Component;

class RunnerLocation extends Component
{
    public $lat;
    public $lng;
    public $distance;
    public $message = '';
    
    public function mount()
    {
        $run = Run::first();
        $this->lat = $run->current_lat ?? 42.4833;
        $this->lng = $run->current_lng ?? 26.5000;
        $this->distance = $run->distance_covered_km ?? 0;
    }
    
    public function updateLocation()
    {
        $this->validate([
            'lat' => 'required|numeric|between:-90,90',
            'lng' => 'required|numeric|between:-180,180',
            'distance' => 'required|numeric|min:0|max:133',
        ]);
        
        $run = Run::first();
        $run->update([
            'current_lat' => $this->lat,
            'current_lng' => $this->lng,
            'distance_covered_km' => $this->distance,
        ]);
        
        $this->message = '✅ Локацията е обновена! Маркерът е на ' . $this->distance . ' км.';
        
        // Изпращаме събитие за обновяване на картата
        $this->dispatch('location-updated');
    }
    
    public function render()
    {
        $run = Run::first();
        return view('livewire.runner-location', compact('run'));
    }
}