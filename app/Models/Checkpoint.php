<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Checkpoint extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'lat',
        'lng',
        'distance_km',
        'order_position'
    ];
    
    protected $casts = [
        'lat' => 'decimal:8',
        'lng' => 'decimal:8',
        'distance_km' => 'integer',
        'order_position' => 'integer'
    ];
    
    // Връща дали е старт, финал или междинна точка
    public function getTypeAttribute()
    {
        if ($this->distance_km === 0) return 'start';
        if ($this->distance_km === 133) return 'finish';
        return 'checkpoint';
    }
    
    // Връща икона според типа
    public function getIconAttribute()
    {
        return match($this->type) {
            'start' => '🏁',
            'finish' => '🏆',
            default => '📍'
        };
    }
}