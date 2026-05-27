<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CheckpointSeeder extends Seeder
{
    public function run()
    {
        $checkpoints = [
            ['name' => 'Ямбол (Старт)', 'lat' => 42.4833, 'lng' => 26.5000, 'distance_km' => 0, 'order' => 1],
            ['name' => 'Нова Загора', 'lat' => 42.4833, 'lng' => 26.0167, 'distance_km' => 30, 'order' => 2],
            ['name' => 'Твърдица', 'lat' => 42.7000, 'lng' => 25.9000, 'distance_km' => 55, 'order' => 3],
            ['name' => 'Елена', 'lat' => 42.9333, 'lng' => 25.8833, 'distance_km' => 90, 'order' => 4],
            ['name' => 'Дебелец', 'lat' => 43.0333, 'lng' => 25.6167, 'distance_km' => 120, 'order' => 5],
            ['name' => 'Велико Търново (Финал)', 'lat' => 43.0758, 'lng' => 25.6178, 'distance_km' => 133, 'order' => 6],
        ];

        foreach ($checkpoints as $cp) {
            DB::table('checkpoints')->insert([
                'name' => $cp['name'],
                'lat' => $cp['lat'],
                'lng' => $cp['lng'],
                'distance_km' => $cp['distance_km'],
                'order_position' => $cp['order'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}