<?php

namespace App\Console\Commands;

use App\Models\Run;
use App\Models\Checkpoint;
use Illuminate\Console\Command;

// php artisan runner:simulate --step=5

class SimulateRunner extends Command
{
    protected $signature = 'runner:simulate {--step=1 : километри на стъпка}';
    protected $description = 'Симулира движението на бегача';

    public function handle()
    {
        $run = Run::first();
        $checkpoints = Checkpoint::orderBy('distance_km')->get();
        
        while ($run->distance_covered_km < 133) {
            $newDistance = $run->distance_covered_km + $this->option('step');
            
            if ($newDistance > 133) {
                $newDistance = 133;
            }
            
            // Намери текущата контролна точка
            $currentCheckpoint = $checkpoints->last(function ($cp) use ($newDistance) {
                return $cp->distance_km <= $newDistance;
            });
            
            // Интерполация на координатите между контролните точки
            $nextCheckpoint = $checkpoints->first(function ($cp) use ($newDistance) {
                return $cp->distance_km > $newDistance;
            });
            
            if ($currentCheckpoint && $nextCheckpoint) {
                $ratio = ($newDistance - $currentCheckpoint->distance_km) / 
                         ($nextCheckpoint->distance_km - $currentCheckpoint->distance_km);
                
                $lat = $currentCheckpoint->lat + ($nextCheckpoint->lat - $currentCheckpoint->lat) * $ratio;
                $lng = $currentCheckpoint->lng + ($nextCheckpoint->lng - $currentCheckpoint->lng) * $ratio;
            } else {
                $lat = $currentCheckpoint->lat;
                $lng = $currentCheckpoint->lng;
            }
            
            $run->update([
                'distance_covered_km' => $newDistance,
                'current_lat' => $lat,
                'current_lng' => $lng,
            ]);
            
            $this->info("🏃‍♂️ Изминати: {$newDistance} км - Позиция: {$lat}, {$lng}");
            
            sleep(2); // Изчаква 2 секунди между обновяванията
        }
        
        $this->info("🎉 ФИНАЛ! Бегачът пристигна във Велико Търново!");
    }
}