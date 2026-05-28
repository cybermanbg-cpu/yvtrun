<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Run;
use App\Models\LocationHistory;
use Illuminate\Http\Request;

class OwnTracksController extends Controller
{
    public function publish(Request $request)
    {
        // 1. Вземаме JSON payload-а
        $payload = $request->getContent();
        $data = json_decode($payload, true);
        
        // 2. Игнорираме празните payload-и
        if (empty($payload) || $payload === '[]') {
            return response()->json([]);
        }
        
        // 3. Вземаме username и device от headers (OwnTracks ги праща)
        $username = $request->header('X-Limit-U');
        $device = $request->header('X-Limit-D');
        
        // Може да се вземат и от URL параметри
        $username = $username ?? $request->query('u');
        $device = $device ?? $request->query('d');
        
        // 4. Проверяваме дали това е съобщение за локация
        if (isset($data['_type']) && $data['_type'] === 'location') {
            
            // 5. Извличаме всички данни
            $lat = $data['lat'] ?? null;
            $lon = $data['lon'] ?? null;
            $tst = $data['tst'] ?? time();  // Unix timestamp
            $batt = $data['batt'] ?? null;   // Батерия (%)
            $tid = $data['tid'] ?? null;     // Tracker ID
            $acc = $data['acc'] ?? null;     // Точност в метри
            $vel = $data['vel'] ?? null;     // Скорост (km/h)
            $alt = $data['alt'] ?? null;     // Надморска височина
            $vac = $data['vac'] ?? null;     // Вертикална точност
            
            // 6. Изчисляваме текущото разстояние от маршрута
            $distance = $this->calculateDistanceOnRoute($lat, $lon);
            
            if ($lat && $lon) {
                // 7. Записваме в таблицата 'runs' (текуща позиция)
                $run = Run::first();
                if ($run) {
                    $run->update([
                        'current_lat' => $lat,
                        'current_lng' => $lon,
                        'distance_covered_km' => $distance,
                    ]);
                }
                
                // 8. Запазваме в историята (LocationHistory)
                try {
                    LocationHistory::create([
                        'lat' => $lat,
                        'lng' => $lon,
                        'distance_km' => $distance,
                        'speed' => $vel,
                        'battery' => $batt,
                        'accuracy' => $acc,
                        'altitude' => $alt,
                        'device_id' => $device ?? $tid,
                        'user_id' => $username,
                        'recorded_at' => date('Y-m-d H:i:s', $tst),
                    ]);
                    
                    // Лог за успех (може да се махне в production)
                    \Log::info('OwnTracks location saved', [
                        'lat' => $lat,
                        'lon' => $lon,
                        'distance' => $distance,
                        'user' => $username,
                        'device' => $device
                    ]);
                    
                } catch (\Exception $e) {
                    \Log::error('Error saving location history: ' . $e->getMessage());
                }
            }
        }
        
        // 9. OwnTracks очаква JSON масив (може да върнем команди, ако искаме)
        return response()->json([]);
    }
    
    /**
     * Изчислява изминатите километри спрямо официалния маршрут
     */
    private function calculateDistanceOnRoute($lat, $lon)
    {
        // Официален маршрут (Ямбол -> В. Търново)
        $routePoints = [
            ['lat' => 42.4833, 'lng' => 26.5000, 'km' => 0],      // Ямбол
            ['lat' => 42.4833, 'lng' => 26.0167, 'km' => 30],     // Нова Загора
            ['lat' => 42.7000, 'lng' => 25.9000, 'km' => 55],     // Твърдица
            ['lat' => 42.9333, 'lng' => 25.8833, 'km' => 90],     // Елена
            ['lat' => 43.0333, 'lng' => 25.6167, 'km' => 120],    // Дебелец
            ['lat' => 43.0758, 'lng' => 25.6178, 'km' => 133],    // В. Търново
        ];
        
        $minDistance = PHP_INT_MAX;
        $closestKm = 0;
        
        for ($i = 0; $i < count($routePoints) - 1; $i++) {
            $p1 = $routePoints[$i];
            $p2 = $routePoints[$i + 1];
            
            // Намиране на проекцията върху сегмента
            $projection = $this->pointToSegmentDistance(
                $lat, $lon,
                $p1['lat'], $p1['lng'],
                $p2['lat'], $p2['lng']
            );
            
            if ($projection['distance'] < $minDistance) {
                $minDistance = $projection['distance'];
                $closestKm = $p1['km'] + $projection['fraction'] * ($p2['km'] - $p1['km']);
            }
        }
        
        return round(max(0, min($closestKm, 133)), 2);
    }
    
    /**
     * Изчислява разстояние от точка до отсечка и фактора на проекция
     */
    private function pointToSegmentDistance($lat, $lng, $lat1, $lng1, $lat2, $lng2)
    {
        $dx = ($lng2 - $lng1) * cos(deg2rad($lat1)) * 111320;
        $dy = ($lat2 - $lat1) * 110574;
        $px = ($lng - $lng1) * cos(deg2rad($lat1)) * 111320;
        $py = ($lat - $lat1) * 110574;
        
        $dot = ($px * $dx + $py * $dy);
        $len2 = ($dx * $dx + $dy * $dy);
        
        if ($len2 == 0) {
            $fraction = 0;
        } else {
            $fraction = max(0, min(1, $dot / $len2));
        }
        
        $projX = $dx * $fraction;
        $projY = $dy * $fraction;
        $distance = sqrt(($px - $projX) ** 2 + ($py - $projY) ** 2) / 1000; // в км
        
        return ['distance' => $distance, 'fraction' => $fraction];
    }
}