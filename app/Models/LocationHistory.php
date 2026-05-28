<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LocationHistory extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'lat', 'lng', 'distance_km', 'speed', 'battery', 'accuracy', 'device_id', 'recorded_at'
    ];
    
    protected $casts = [
        'lat' => 'decimal:8',
        'lng' => 'decimal:8',
        'distance_km' => 'decimal:2',
        'speed' => 'float',
        'battery' => 'float',
        'accuracy' => 'integer',
        'recorded_at' => 'datetime'
    ];
    
    // Взема последните N локации
    public static function getRecent($limit = 100)
    {
        return self::orderBy('recorded_at', 'desc')->limit($limit)->get();
    }
    
    // Взема целия маршрут за деня
    public static function getTodayRoute()
    {
        return self::whereDate('recorded_at', today())
            ->orderBy('recorded_at', 'asc')
            ->get();
    }
    
    // Изчислява общото изминато разстояние от историята
    public static function getTotalDistanceFromHistory()
    {
        $locations = self::orderBy('recorded_at', 'asc')->get();
        $total = 0;
        
        for ($i = 1; $i < $locations->count(); $i++) {
            $total += self::calculateDistance(
                $locations[$i-1]->lat, $locations[$i-1]->lng,
                $locations[$i]->lat, $locations[$i]->lng
            );
        }
        
        return $total;
    }
    
    // Haversine формула за разстояние между две точки
    private static function calculateDistance($lat1, $lng1, $lat2, $lng2)
    {
        $earthRadius = 6371;
        $dLat = deg2rad($lat2 - $lat1);
        $dLng = deg2rad($lng2 - $lng1);
        $a = sin($dLat/2) * sin($dLat/2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($dLng/2) * sin($dLng/2);
        $c = 2 * atan2(sqrt($a), sqrt(1-$a));
        return $earthRadius * $c;
    }
}