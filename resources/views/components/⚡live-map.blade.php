<?php

namespace App\Livewire;

use App\Models\Run;
use App\Models\Checkpoint;
use Livewire\Component;

class LiveMap extends Component
{
    public $run;
    public $checkpoints;
    
    protected $listeners = ['locationUpdated' => 'refreshLocation'];
    
    public function mount()
    {
        $this->run = Run::first();
        $this->checkpoints = Checkpoint::orderBy('order_position')->get();
    }
    
    public function refreshLocation()
    {
        $this->run = Run::first();
    }
    
    public function render()
    {
        return view('livewire.live-map');
    }
}