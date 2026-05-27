<?php

namespace App\Livewire;

use App\Models\Run;
use Livewire\Component;

class LiveMap extends Component
{
    public $runnerLat;
    public $runnerLng;
    public $distanceCovered;
    
    protected $listeners = ['location-updated' => 'refreshLocation'];
    
    public function mount()
    {
        $this->refreshLocation();
    }
    
    public function refreshLocation()
    {
        $run = Run::first();
        $this->runnerLat = $run->current_lat ?? 42.4833;
        $this->runnerLng = $run->current_lng ?? 26.5000;
        $this->distanceCovered = $run->distance_covered_km ?? 0;
        
        // Изпращаме събитие за обновяване на картата
        $this->dispatch('location-updated');
    }
    
    public function render()
    {
        return view('livewire.live-map');
    }
}