<!DOCTYPE html>
<html lang="bg">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>🏃‍♂️ YVTRun - Благотворително бягане Ямбол до Велико Търново 133км</title>

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8 max-w-6xl">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-5xl font-bold text-red-600 mb-2">🏃‍♂️ Ямбол → Велико Търново</h1>
            <p class="text-xl text-gray-600">133 км благотворително бягане</p>
            <div class="mt-2 text-amber-600">
                ⭐ Бягаме заедно, помагаме на нуждаещите се ⭐
            </div>
        </div>

        <!-- 📊 Секция за даренията -->
        <div class="mb-8">
            <div class="bg-gradient-to-r from-green-500 to-green-700 rounded-xl shadow-lg p-6 text-white">
                <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                    <div class="text-center md:text-left">
                        <p class="text-sm uppercase tracking-wide opacity-90">Събрани средства</p>
                        <p class="text-4xl font-bold">{{ number_format($totalRaised, 0) }} €</p>
                        <p class="text-sm opacity-90">от цел {{ number_format($goalAmount, 0) }} €</p>
                    </div>

                    <div class="flex-1 w-full max-w-md">
                        <div class="w-full bg-white/30 rounded-full h-4 overflow-hidden">
                            <div class="bg-yellow-400 h-4 rounded-full transition-all duration-500" 
                                style="width: {{ min($percentage, 100) }}%"></div>
                        </div>
                        <p class="text-sm text-center mt-2">{{ number_format($percentage, 1) }}% от целта</p>
                    </div>

                    <div class="text-center md:text-right">
                        <p class="text-sm uppercase tracking-wide opacity-90">Дарители</p>
                        <p class="text-3xl font-bold">{{ $donorsCount }}</p>
                        <p class="text-sm opacity-90">❤️ благодетели</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Карта -->
        <div class="bg-white rounded-lg shadow-lg p-4 mb-8">
            <div id="map" style="height: 500px; width: 100%;"></div>
            
            <div class="mt-4">
                <div class="bg-gradient-to-r from-red-500 to-orange-500 rounded-lg p-4 text-white">
                    <h3 class="font-bold text-xl mb-2">📊 Напредък на бягането</h3>
                    <div class="flex justify-between items-center mb-2">
                        <span>Изминати километри:</span>
                        <span class="font-mono text-2xl font-bold" id="distanceDisplay">0 / 133 км</span>
                    </div>
                    <div class="w-full bg-white/30 rounded-full h-4 overflow-hidden">
                        <div class="bg-yellow-400 h-4 rounded-full transition-all duration-500" id="progressBar" style="width: 0%"></div>
                    </div>
                    <div id="coordDisplay" class="text-xs mt-2 opacity-75">📍 Координати: -</div>
                </div>
            </div>
        </div>

        <!-- Контролни точки -->
        <div class="bg-white rounded-lg shadow p-4 mb-8">
            <h2 class="text-xl font-bold mb-2">📍 Контролни точки</h2>
            <div class="grid grid-cols-3 md:grid-cols-6 gap-2 text-sm">
                <span>🏁 Ямбол (0км)</span>
                <span>📍 Нова Загора (30км)</span>
                <span>📍 Твърдица (55км)</span>
                <span>📍 Елена (90км)</span>
                <span>📍 Дебелец (120км)</span>
                <span>🏆 В. Търново (133км)</span>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="mt-8 flex flex-wrap gap-4 justify-center">
            <a href="{{ route('volunteers.index') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 px-6 rounded-full transition shadow-lg transform hover:scale-105">
                🤝 Стани доброволец
            </a>
            <a href="{{ route('donations.index') }}" class="bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-6 rounded-full transition shadow-lg transform hover:scale-105">
                ❤️ Дари сега
            </a>
            <a href="/simple-runner" class="bg-purple-500 hover:bg-purple-600 text-white font-bold py-3 px-6 rounded-full transition shadow-lg transform hover:scale-105">
                🏃‍♂️ Панел на бегача
            </a>
        </div>
        
        <!-- 🤝 Секция за доброволци -->
        <div class="mt-8 mb-8">
            <div class="bg-gradient-to-r from-blue-500 to-blue-700 rounded-xl shadow-lg p-6 text-white">
                <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                    <div class="text-center md:text-left">
                        <p class="text-sm uppercase tracking-wide opacity-90">Нашият екип</p>
                        <p class="text-4xl font-bold">{{ $volunteersCount }}</p>
                        <p class="text-sm opacity-90">🤝 записани доброволци</p>
                    </div>
                    <div>
                        <a href="{{ route('volunteers.index') }}" class="bg-white text-blue-600 hover:bg-blue-50 font-bold py-2 px-6 rounded-full transition">
                            🤝 Стани доброволец
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .runner-marker {
            background: none;
            border: none;
            font-size: 40px;
            filter: drop-shadow(2px 2px 2px rgba(0, 0, 0, 0.3));
            animation: bounce 0.5s infinite;
        }

        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
    </style>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        let map = null;
        let runnerMarker = null;
        let circle = null;
        
        // Контролни точки от PHP
        const checkpoints = @json($checkpoints);
        
        function initMap() {
            const initialLat = 42.4833;
            const initialLng = 26.5000;
            
            map = L.map('map').setView([initialLat, initialLng], 8);
            
            L.tileLayer('https://{s}.tile.openstreetmap.fr/hot/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap'
            }).addTo(map);
            
            // Добавяне на контролните точки
            checkpoints.forEach(cp => {
                const emoji = cp.distance_km === 0 ? '🏁' : (cp.distance_km === 133 ? '🏆' : '📍');
                L.marker([parseFloat(cp.lat), parseFloat(cp.lng)], {
                    icon: L.divIcon({ html: emoji, iconSize: [28, 28] })
                }).bindPopup(`${cp.name}<br>${cp.distance_km} км`).addTo(map);
            });
            
            // Стартиране на периодично обновяване
            startPolling();
        }
        
        function updateRunnerMarker(lat, lng, distance) {
            if (!map) return;
            
            console.log('📍 Обновяване на позиция:', lat, lng, distance);
            
            // Покажи координатите
            document.getElementById('coordDisplay').innerHTML = `📍 Координати: ${lat.toFixed(6)}, ${lng.toFixed(6)}`;
            
            // Премахване на старите слоеве
            if (runnerMarker) map.removeLayer(runnerMarker);
            if (circle) map.removeLayer(circle);
            
            // Маркер за бегача
            const runnerIcon = L.divIcon({
                className: 'runner-marker',
                html: '🏃‍♂️',
                iconSize: [40, 40]
            });
            
            runnerMarker = L.marker([lat, lng], { icon: runnerIcon })
                .bindPopup(`🏃‍♂️ Бегачът е тук!<br>📍 ${lat.toFixed(6)}, ${lng.toFixed(6)}<br>📏 ${distance.toFixed(1)} км`)
                .addTo(map);
            
            // Кръг за визуализация (100 метра)
            circle = L.circle([lat, lng], {
                color: 'red',
                fillColor: '#f03',
                fillOpacity: 0.2,
                radius: 100
            }).addTo(map);
            
            // Центриране на картата
            map.setView([lat, lng], 14);
            
            // Обнови дисплея
            document.getElementById('distanceDisplay').innerHTML = distance.toFixed(1) + ' / 133 км';
            document.getElementById('progressBar').style.width = (distance / 133 * 100) + '%';
        }
        
        function startPolling() {
            setInterval(async function() {
                try {
                    const response = await fetch('/current-runner-position');
                    const data = await response.json();
                    
                    if (data && data.lat && data.lng) {
                        const lat = parseFloat(data.lat);
                        const lng = parseFloat(data.lng);
                        const distance = parseFloat(data.distance);
                        
                        if (!isNaN(lat) && !isNaN(lng)) {
                            updateRunnerMarker(lat, lng, distance);
                        }
                    }
                } catch (error) {
                    console.error('Грешка при polling:', error);
                }
            }, 2000);
        }
        
        // Стартиране на картата
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(initMap, 100);
        });
    </script>
</body>
</html>