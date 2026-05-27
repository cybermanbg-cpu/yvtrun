<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Run;

class RunSeeder extends Seeder
{
    public function run()
    {
        // Изтрива старите записи
        Run::truncate();
        
        // Създава първоначалния запис за бягането
        Run::create([
            'name' => 'Yambol to Veliko Tarnovo 133km',
            'start_time' => null,  // още не е започнало
            'end_time' => null,
            'current_lat' => 42.4833,  // Ямбол
            'current_lng' => 26.5000,
            'distance_covered_km' => 0,
            'is_active' => false
        ]);
    }
}