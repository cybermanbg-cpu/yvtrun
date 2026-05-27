<?php

namespace App\Livewire;

use App\Models\Run;
use Livewire\Component;

class AdminRunControl extends Component
{
    public $run;
    public $distance;
    public $lat;
    public $lng;
    
    public function mount()
    {
        $this->run = Run::first();
        $this->distance = $this->run->distance_covered_km;
        $this->lat = $this->run->current_lat;
        $this->lng = $this->run->current_lng;
    }
    
    public function updatePosition()
    {
        $this->run->update([
            'distance_covered_km' => $this->distance,
            'current_lat' => $this->lat,
            'current_lng' => $this->lng,
        ]);
        
        // Тука ще пуснем event за WebSocket (по-късно)
        session()->flash('message', 'Позицията е обновена!');
    }
    
    public function render()
    {
        return view('livewire.admin-run-control');
    }
}