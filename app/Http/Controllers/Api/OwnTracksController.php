<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LocationHistory;
use App\Models\Run;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OwnTracksController extends Controller
{
    public function publish(Request $request)
    {
        $payload = $request->getContent();
        $data = json_decode($payload, true);

        // Логване за debugging
        Log::info('OwnTracks received payload', [
            'headers' => $request->headers->all(),
            'payload' => $data
        ]);

        if (!$data || !isset($data['_type']) || $data['_type'] !== 'location') {
            return response()->json([]);
        }

        $lat = $data['lat'] ?? null;
        $lon = $data['lon'] ?? null;

        if (!$lat || !$lon) {
            Log::warning('OwnTracks: Missing lat/lon');
            return response()->json([], 400);
        }

        // Username и device - OwnTracks често ги праща по различни начини
        $username = $request->header('X-Limit-U') 
                 ?? $request->query('u') 
                 ?? $data['tid'] 
                 ?? 'yvt-runner';

        $device = $request->header('X-Limit-D') 
               ?? $request->query('d') 
               ?? $data['device'] 
               ?? 'owntracks';

        $distance = $this->calculateDistanceOnRoute($lat, $lon);

        try {
            // Обновяване на текущата позиция
            $run = Run::firstOrCreate(['id' => 1]);

            $run->update([
                'current_lat' => $lat,
                'current_lng' => $lon,
                'distance_covered_km' => $distance,
                'last_updated_at' => now(),
            ]);

            // Запис в историята
            LocationHistory::create([
                'lat'          => $lat,
                'lng'          => $lon,
                'distance_km'  => $distance,
                'speed'        => $data['vel'] ?? null,
                'battery'      => $data['batt'] ?? null,
                'accuracy'     => $data['acc'] ?? null,
                'altitude'     => $data['alt'] ?? null,
                'device_id'    => $device,
                'user_id'      => $username,
                'recorded_at'  => date('Y-m-d H:i:s', $data['tst'] ?? time()),
            ]);

            Log::info('OwnTracks location saved', [
                'lat' => $lat,
                'lon' => $lon,
                'distance' => $distance,
                'user' => $username
            ]);

        } catch (\Exception $e) {
            Log::error('OwnTracks error: ' . $e->getMessage());
            return response()->json(['error' => 'Internal error'], 500);
        }

        return response()->json([]); // OwnTracks изисква празен отговор
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