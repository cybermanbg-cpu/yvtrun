<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Run extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'start_time',
        'end_time',
        'current_lat',
        'current_lng',
        'distance_covered_km',
        'is_active'
    ];
    
    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'current_lat' => 'decimal:8',
        'current_lng' => 'decimal:8',
        'distance_covered_km' => 'decimal:2',
        'is_active' => 'boolean'
    ];
    
    // Връща процента на завършване
    public function getCompletionPercentageAttribute()
    {
        return ($this->distance_covered_km / 133) * 100;
    }
    
    // Връща следващата контролна точка
    public function nextCheckpoint()
    {
        return Checkpoint::where('distance_km', '>=', $this->distance_covered_km)
            ->orderBy('distance_km')
            ->first();
    }
    
    // Връща оставащи километри
    public function getRemainingDistanceAttribute()
    {
        return 133 - $this->distance_covered_km;
    }
}