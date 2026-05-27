<?php

namespace App\Livewire;

use App\Models\Run;
use App\Models\Checkpoint;
use Livewire\Component;

class LiveMap extends Component
{
    public $run;
    public $checkpoints;
    public $runnerLat;
    public $runnerLng;
    public $distanceCovered;
    
    public function mount()
    {
        $this->run = Run::first();
        $this->checkpoints = Checkpoint::orderBy('order_position')->get();
        $this->runnerLat = $this->run->current_lat ?? 42.4833;
        $this->runnerLng = $this->run->current_lng ?? 26.5000;
        $this->distanceCovered = $this->run->distance_covered_km ?? 0;
    }
    
    public function render()
    {
        return view('livewire.live-map');
    }
}