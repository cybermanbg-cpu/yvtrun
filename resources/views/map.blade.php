<!DOCTYPE html>
<html lang="bg">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- ========== ОСНОВНИ МЕТА ТАГОВЕ ========== -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description"
        content="Присъединете се към благотворителното бягане от Ямбол до Велико Търново (133 км)! Следете локацията на бегача на живо, дарете или станете доброволец.">
    <meta name="keywords"
        content="бягане, благотворителност, Ямбол, Велико Търново, маратон, спорт, доброволци, дарение">
    <meta name="author" content="YVTRun">
    <meta name="robots" content="index, follow, max-image-preview:large">
    <meta name="theme-color" content="#e74c3c">

    <!-- ========== OPEN GRAPH (Facebook, LinkedIn, WhatsApp, Telegram) ========== -->
    <meta property="og:title" content="🏃‍♂️ Антон бяга 133 км за благотворителност | YVTRun">
    <meta property="og:description"
        content="🏃‍♂️ 133 км благотворително бягане от Ямбол до Велико Търново. Следете на живо, дарете или станете доброволец!">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="bg_BG">
    <meta property="og:site_name" content="YVTRun">
    <meta property="og:image" content="{{ asset('images/og-image.jpg') }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="YVTRun Антон - Благотворително бягане от Ямбол до Велико Търново">
    <meta property="og:image:type" content="image/jpeg">

    <!-- ========== TWITTER CARD ========== -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="🏃‍♂️ Антон бяга 133 км за благотворителност | YVTRun">
    <meta name="twitter:description"
        content="Следете на живо благотворителното бягане от Ямбол до Велико Търново. Дарете или станете доброволец!">
    <meta name="twitter:image" content="{{ asset('images/og-image.jpg') }}">
    <meta name="twitter:site" content="@yvtrun">
    <meta name="twitter:creator" content="@yvtrun">

    <!-- ========== ДОПЪЛНИТЕЛНО ЗА WhatsApp И ДРУГИ ========== -->
    <meta property="og:image:secure_url" content="{{ asset('images/og-image.jpg') }}">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">

    <!-- ========== ДИНАМИЧЕН TITLE (актуализира се с напредъка) ========== -->
    <title>🏃‍♂️ YVTRun - Антон - Благотворително бягане Ямбол → Велико Търново 133км за 24 часа</title>

    <!-- MapLibre GL CSS -->
    <link href="https://unpkg.com/maplibre-gl@4.0.0/dist/maplibre-gl.css" rel="stylesheet" />

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        .runner-marker {
            background: none;
            border: none;
            font-size: 42px;
            line-height: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 50px;
            height: 50px;
            cursor: pointer;
            filter: drop-shadow(2px 2px 4px rgba(0, 0, 0, 0.4));
            animation: bounce 0.6s infinite;
            user-select: none;
            pointer-events: auto;
        }

        @keyframes bounce {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-12px);
            }
        }

        #timeline-controls {
            transition: all 0.3s ease;
            border: 2px solid #8e44ad;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        }

        #timelineSlider {
            accent-color: #8e44ad;
        }

        #timelineSlider::-webkit-slider-thumb {
            -webkit-appearance: none;
            appearance: none;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: #8e44ad;
            cursor: pointer;
            border: 3px solid white;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
        }

        .speed-btn {
            min-width: 40px;
            font-weight: bold;
            transition: all 0.2s ease;
        }

        .speed-btn.bg-blue-500 {
            transform: scale(1.05);
            box-shadow: 0 2px 8px rgba(59, 130, 246, 0.3);
        }
        
        .date-btn {
            transition: all 0.2s ease;
        }
        
        .date-btn.active {
            transform: scale(1.05);
            box-shadow: 0 2px 8px rgba(16, 185, 129, 0.4);
        }
    </style>
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

        <!-- Action Buttons -->
        <div class="flex flex-wrap gap-2 mb-4">
            <button onclick="centerOnRunner()"
                class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition shadow">
                🎯 Центрирай върху Антон
            </button>

            <button onclick="clearTrail()"
                class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition shadow">
                🧹 Изчисти следата
            </button>

            <button onclick="loadFullHistory()"
                class="bg-purple-500 hover:bg-purple-600 text-white px-4 py-2 rounded-lg transition shadow">
                📜 Зареди пълна история
            </button>

            <button onclick="resetMapView()"
                class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg transition shadow">
                🗺️ Цялата карта
            </button>
        </div>

        <!-- Таймлайн бутони за дати -->
        <div class="flex flex-wrap gap-2 mb-4">
            <button onclick="loadTimelineHistory('2026-06-23')" 
                class="date-btn bg-amber-500 hover:bg-amber-600 text-white px-4 py-2 rounded-lg transition shadow">
                📅 23 юни 2026
            </button>
            
            <button onclick="loadTimelineHistory('2026-06-24')" 
                class="date-btn bg-amber-500 hover:bg-amber-600 text-white px-4 py-2 rounded-lg transition shadow">
                📅 24 юни 2026
            </button>
            
            <button onclick="loadTimelineHistory()" 
                class="date-btn bg-emerald-500 hover:bg-emerald-600 text-white px-4 py-2 rounded-lg transition shadow">
                📅 Цялото бягане (23-24 юни)
            </button>
            
            <button onclick="loadTimelineHistory('today')" 
                class="date-btn bg-teal-500 hover:bg-teal-600 text-white px-4 py-2 rounded-lg transition shadow">
                📅 Днес
            </button>
            
            <button onclick="closeTimeline()" 
                class="date-btn bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition shadow">
                ❌ Затвори таймлайн
            </button>
        </div>

        <!-- Карта -->
        <div class="bg-white rounded-lg shadow-lg p-4 mb-8">
            <div id="map-loading" class="text-center py-20 text-gray-400">🗺️ Зареждане на картата...</div>
            <div id="map" style="height: 500px; width: 100%; display: none;"></div>

            <div class="mt-4">
                <div class="bg-gradient-to-r from-red-500 to-orange-500 rounded-lg p-4 text-white">
                    <h3 class="font-bold text-xl mb-2">📊 Напредък</h3>
                    <div class="flex justify-between items-center mb-2">
                        <span>Изминати км:</span>
                        <span class="font-mono text-2xl font-bold" id="distanceDisplay">0 / 133 км</span>
                    </div>
                    <div class="w-full bg-white/30 rounded-full h-4 overflow-hidden">
                        <div class="bg-yellow-400 h-4 rounded-full transition-all duration-500" id="progressBar"
                            style="width: 0%"></div>
                    </div>
                    <div id="coordDisplay" class="text-xs mt-2 opacity-75"></div>
                </div>
            </div>
        </div>

        <!-- Контролни точки -->
        <div class="bg-white rounded-lg shadow p-4 mb-8">
            <h2 class="text-xl font-bold mb-2">📍 Контролни точки</h2>
            <div class="grid grid-cols-3 md:grid-cols-6 gap-2 text-sm">
                <span>🏁 Ямбол (0км)</span>
                <span>📍 Сливен (30км)</span>
                <span>📍 Гурково (70км)</span>
                <span>📍 Прохода на Републиката (90км)</span>
                <span>📍 Дебелец (120км)</span>
                <span>🏆 В. Търново (133км)</span>
            </div>
        </div>

        <!-- 🎥 YouTube Видеа секция -->
        <div class="mb-8">
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-2xl font-bold mb-4 flex items-center gap-2">
                    <span class="text-red-600">🎥</span>
                    Видео от бягането
                </h2>

                @if ($liveVideo)
                    <div class="mb-8">
                        <div class="relative">
                            <div
                                class="absolute top-2 left-2 z-10 bg-red-600 text-white px-3 py-1 rounded-full text-sm font-bold animate-pulse">
                                🔴 НА ЖИВО
                            </div>
                            <div class="aspect-video w-full rounded-lg overflow-hidden shadow-lg">
                                <iframe class="w-full h-full" src="{{ $liveVideo->embed_url }}"
                                    title="{{ $liveVideo->title }}" frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen>
                                </iframe>
                            </div>
                            <p class="text-center mt-2 font-bold text-gray-700">{{ $liveVideo->title }}</p>
                        </div>
                    </div>
                @else
                    <div class="mb-8 bg-gray-100 rounded-lg p-6 text-center">
                        <div class="text-4xl mb-2">📺</div>
                        <p class="text-gray-500">Все още няма активен лайфстрийм</p>
                        <p class="text-sm text-gray-400">Очаквайте скоро!</p>
                    </div>
                @endif

                @if ($pastVideos->count() > 0)
                    <div>
                        <h3 class="text-xl font-bold mb-3 flex items-center gap-2">
                            <span class="text-gray-600">📼</span>
                            Предишни видеа
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach ($pastVideos as $video)
                                <div class="border rounded-lg overflow-hidden hover:shadow-lg transition">
                                    <div class="aspect-video w-full bg-gray-200">
                                        <iframe class="w-full h-full" src="{{ $video->embed_url }}"
                                            title="{{ $video->title }}" frameborder="0"
                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                            allowfullscreen>
                                        </iframe>
                                    </div>
                                    <div class="p-3">
                                        <p class="font-medium text-gray-800 text-sm">{{ $video->title }}</p>
                                        <p class="text-xs text-gray-500 mt-1">
                                            {{ $video->created_at->format('d.m.Y H:i') }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/maplibre-gl@4.0.0/dist/maplibre-gl.js"></script>

    <script>
        let map = null;
        let runnerMarker = null;
        let trailPoints = [];
        let historyLine = null;
        let isTimelineMode = false;
        let trackingInterval = null;
        let isTrackingPaused = false;

        function initMap() {
            document.getElementById('map-loading').style.display = 'none';
            document.getElementById('map').style.display = 'block';

            map = new maplibregl.Map({
                container: 'map',
                style: {
                    version: 8,
                    sources: {
                        'osm': {
                            type: 'raster',
                            tiles: ['https://tile.openstreetmap.org/{z}/{x}/{y}.png'],
                            tileSize: 256,
                            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
                        }
                    },
                    layers: [{
                        id: 'osm',
                        type: 'raster',
                        source: 'osm'
                    }]
                },
                center: [26.5000, 42.4833],
                zoom: 8
            });

            map.addControl(new maplibregl.NavigationControl(), 'top-right');
            map.addControl(new maplibregl.FullscreenControl());
            map.addControl(new maplibregl.ScaleControl());

            map.on('load', () => {
                const checkpoints = @json($checkpoints);
                const routePoints = [];

                checkpoints.forEach(cp => {
                    const lat = parseFloat(cp.lat);
                    const lng = parseFloat(cp.lng);
                    routePoints.push([lng, lat]);

                    const emoji = cp.distance_km === 0 ? '🏁' : (cp.distance_km === 133 ? '🏆' : '📍');
                    const markerDiv = document.createElement('div');
                    markerDiv.innerHTML = emoji;
                    markerDiv.style.fontSize = '32px';
                    markerDiv.style.cursor = 'pointer';

                    new maplibregl.Marker(markerDiv)
                        .setLngLat([lng, lat])
                        .setPopup(new maplibregl.Popup().setHTML(`${cp.name}<br>📏 ${cp.distance_km} км`))
                        .addTo(map);
                });

                // Официален маршрут
                map.addSource('route', {
                    type: 'geojson',
                    data: {
                        type: 'Feature',
                        geometry: {
                            type: 'LineString',
                            coordinates: routePoints
                        }
                    }
                });

                map.addLayer({
                    id: 'route',
                    type: 'line',
                    source: 'route',
                    layout: {
                        'line-join': 'round',
                        'line-cap': 'round'
                    },
                    paint: {
                        'line-color': '#2980b9',
                        'line-width': 5,
                        'line-opacity': 0.8,
                        'line-dasharray': [8, 6]
                    }
                });

                startTracking();
            });
        }

        function updateRunnerPosition(lat, lng, distance, fromTimeline = false) {
            if (!map) return;

            document.getElementById('coordDisplay').innerHTML =
                `📍 ${lat.toFixed(6)}, ${lng.toFixed(6)} | 🛤️ Точки: ${trailPoints.length}`;
            document.getElementById('distanceDisplay').innerHTML = distance.toFixed(1) + ' / 133 км';
            document.getElementById('progressBar').style.width = Math.min((distance / 133 * 100), 100) + '%';

            // Ако сме в таймлайн режим, не добавяме точки към следата
            if (!fromTimeline) {
                // Добавяне на точка към текущата следа (само за реално проследяване)
                const newPoint = [lat, lng];
                if (trailPoints.length === 0 ||
                    Math.hypot(trailPoints[trailPoints.length - 1][0] - lat, trailPoints[trailPoints.length - 1][1] - lng) >
                    0.00008) {
                    trailPoints.push(newPoint);
                }

                const trailCoordinates = trailPoints.map(p => [p[1], p[0]]);

                // Обновяваме следата
                if (map.getLayer('trail')) {
                    if (map.getSource('trail')) {
                        map.getSource('trail').setData({
                            type: 'Feature',
                            geometry: {
                                type: 'LineString',
                                coordinates: trailCoordinates
                            }
                        });
                    }
                } else {
                    if (map.getSource('trail')) {
                        map.removeSource('trail');
                    }
                    
                    map.addSource('trail', {
                        type: 'geojson',
                        data: {
                            type: 'Feature',
                            geometry: {
                                type: 'LineString',
                                coordinates: trailCoordinates
                            }
                        }
                    });

                    map.addLayer({
                        id: 'trail',
                        type: 'line',
                        source: 'trail',
                        layout: {
                            'line-join': 'round',
                            'line-cap': 'round'
                        },
                        paint: {
                            'line-color': '#e74c3c',
                            'line-width': 6,
                            'line-opacity': 0.85
                        }
                    });
                }
            }

            // Текущ пин на бегача
            if (runnerMarker) runnerMarker.remove();

            const pinDiv = document.createElement('div');
            pinDiv.innerHTML = `
                <div style="background:#e74c3c; color:white; width:36px; height:36px; border-radius:50% 50% 50% 0;
                            display:flex; align-items:center; justify-content:center; font-size:19px;
                            box-shadow:0 5px 12px rgba(231,76,60,0.6); transform:rotate(-45deg); border:3px solid white;">
                    <span style="transform:rotate(45deg);">🏃</span>
                </div>
            `;

            runnerMarker = new maplibregl.Marker({
                    element: pinDiv,
                    anchor: 'bottom',
                    offset: [0, 0]
                })
                .setLngLat([lng, lat])
                .setPopup(new maplibregl.Popup({
                        offset: 40,
                        closeButton: false
                    })
                    .setHTML(`
                        <div style="text-align:center; min-width:170px;">
                            <b style="color:#e74c3c;">🏃‍♂️ Антон Е ТУК</b><br>
                            📍 ${lat.toFixed(6)}, ${lng.toFixed(6)}<br>
                            📏 ${distance.toFixed(1)} км
                        </div>
                    `))
                .addTo(map);
        }

        function startTracking() {
            // Зареждане на запазената следа
            fetch('/get-runner-trail')
                .then(res => res.json())
                .then(data => {
                    if (data.trail && data.trail.length > 0) {
                        trailPoints = data.trail;
                        const trailCoordinates = trailPoints.map(p => [p[1], p[0]]);
                        if (map.getSource('trail')) {
                            map.getSource('trail').setData({
                                type: 'Feature',
                                geometry: {
                                    type: 'LineString',
                                    coordinates: trailCoordinates
                                }
                            });
                        }
                    }
                })
                .catch(err => console.error(err));

            // Първоначална позиция
            fetch('/current-runner-position')
                .then(res => res.json())
                .then(data => {
                    if (!isTimelineMode) {
                        updateRunnerPosition(parseFloat(data.lat), parseFloat(data.lng), parseFloat(data.distance));
                    }
                })
                .catch(err => console.error(err));

            // Обновяване на всеки 2 секунди - само ако не сме в таймлайн режим
            if (trackingInterval) {
                clearInterval(trackingInterval);
            }
            
            trackingInterval = setInterval(() => {
                // Проверяваме дали сме в таймлайн режим
                if (isTimelineMode) {
                    return; // Пропускаме обновяването
                }
                
                fetch('/current-runner-position')
                    .then(res => res.json())
                    .then(data => {
                        updateRunnerPosition(parseFloat(data.lat), parseFloat(data.lng), parseFloat(data
                            .distance));
                        saveTrail();
                    })
                    .catch(err => console.error(err));
            }, 2000);
        }

        function saveTrail() {
            if (trailPoints.length < 2) return;
            fetch('/save-runner-trail', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    trail: trailPoints
                })
            }).catch(err => console.error(err));
        }

        function centerOnRunner() {
            if (runnerMarker) {
                const lngLat = runnerMarker.getLngLat();
                map.flyTo({
                    center: [lngLat.lng, lngLat.lat],
                    zoom: 15,
                    duration: 1000
                });
            }
        }

        function resetMapView() {
            map.flyTo({
                center: [26.5000, 42.4833],
                zoom: 8,
                duration: 1000
            });
        }

        function clearTrail() {
            trailPoints = [];
            if (map.getSource('trail')) {
                map.getSource('trail').setData({
                    type: 'Feature',
                    geometry: {
                        type: 'LineString',
                        coordinates: []
                    }
                });
            }
            document.getElementById('coordDisplay').innerHTML = `📍 Следата е изчистена`;
            saveTrail();
        }

        // ==================== ИСТОРИЯ ====================
        async function loadFullHistory() {
            try {
                const res = await fetch('/get-location-history');
                const data = await res.json();

                if (!data.history || data.history.length < 3) {
                    alert('Няма достатъчно исторически данни.');
                    return;
                }

                const coords = data.history.map(p => [p.lng, p.lat]);

                if (map.getLayer('history-line')) {
                    map.removeLayer('history-line');
                }
                if (map.getSource('history-line')) {
                    map.removeSource('history-line');
                }

                map.addSource('history-line', {
                    type: 'geojson',
                    data: {
                        type: 'Feature',
                        geometry: {
                            type: 'LineString',
                            coordinates: coords
                        }
                    }
                });

                map.addLayer({
                    id: 'history-line',
                    type: 'line',
                    source: 'history-line',
                    layout: {
                        'line-join': 'round',
                        'line-cap': 'round'
                    },
                    paint: {
                        'line-color': '#8e44ad',
                        'line-width': 4.5,
                        'line-opacity': 0.75,
                        'line-dasharray': [1, 2]
                    }
                });

                alert(`Заредена пълна история с ${data.history.length} точки (лилава пунктирана линия)`);
            } catch (e) {
                console.error(e);
                alert('Грешка при зареждане на историята.');
            }
        }

        function clearHistory() {
            if (map.getSource('history-line')) {
                map.getSource('history-line').setData({
                    type: 'Feature',
                    geometry: {
                        type: 'LineString',
                        coordinates: []
                    }
                });
            }
            alert('Историческата линия е изчистена от картата.');
        }

        // ==================== ТАЙМЛАЙН ФУНКЦИОНАЛНОСТ ====================

        let timelineControls = null;
        let timelineSlider = null;
        let currentTimelineIndex = 0;
        let isPlayingTimeline = false;
        let timelinePlayInterval = null;
        let timelineData = [];
        let timelineUpdateInterval = null;

        function createTimelineControls() {
            // Създаване на контроли за таймлайн
            const timelineContainer = document.createElement('div');
            timelineContainer.id = 'timeline-controls';
            timelineContainer.className = 'mt-4 p-4 bg-gray-100 rounded-lg';
            timelineContainer.style.display = 'none';

            timelineContainer.innerHTML = `
                <div class="flex items-center gap-4 flex-wrap">
                    <button onclick="toggleTimelinePlay()" id="playBtn" 
                        class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition shadow">
                        ▶️ Възпроизвеждане
                    </button>
                    
                    <button onclick="resetTimeline()" 
                        class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition shadow">
                        🔄 Нулирай
                    </button>
                    
                    <button onclick="showFullTimeline()" 
                        class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg transition shadow">
                        📊 Покажи целия маршрут
                    </button>
                    
                    <div class="flex-1 min-w-[200px]">
                        <input type="range" id="timelineSlider" 
                            min="0" max="100" value="0" step="1"
                            class="w-full h-2 bg-gray-300 rounded-lg appearance-none cursor-pointer">
                        <div class="flex justify-between text-xs mt-1">
                            <span id="timelineTime">00:00:00</span>
                            <span id="timelineProgress">0%</span>
                            <span id="timelineDistance">0.0 км</span>
                        </div>
                    </div>
                    
                    <div class="flex gap-2">
                        <button onclick="setTimelineSpeed(1)" class="speed-btn bg-blue-500 text-white px-3 py-1 rounded text-sm" data-speed="1">1x</button>
                        <button onclick="setTimelineSpeed(2)" class="speed-btn bg-gray-300 hover:bg-gray-400 px-3 py-1 rounded text-sm" data-speed="2">2x</button>
                        <button onclick="setTimelineSpeed(5)" class="speed-btn bg-gray-300 hover:bg-gray-400 px-3 py-1 rounded text-sm" data-speed="5">5x</button>
                        <button onclick="setTimelineSpeed(10)" class="speed-btn bg-gray-300 hover:bg-gray-400 px-3 py-1 rounded text-sm" data-speed="10">10x</button>
                    </div>
                </div>
                <div id="timelineInfo" class="mt-2 text-sm text-gray-600"></div>
            `;

            const mapContainer = document.getElementById('map');
            mapContainer.parentNode.insertBefore(timelineContainer, mapContainer.nextSibling);

            timelineSlider = document.getElementById('timelineSlider');

            timelineSlider.addEventListener('input', function() {
                if (timelineData && timelineData.length > 0) {
                    const index = Math.floor((this.value / 100) * (timelineData.length - 1));
                    showTimelinePoint(index);
                }
            });

            return timelineContainer;
        }

        async function loadTimelineHistory(date = null) {
            try {
                // Спираме реалното проследяване
                isTimelineMode = true;
                
                let url = '/location-history';
                if (date === 'today') {
                    url = '/location-history/today';
                } else if (date) {
                    url += '/' + date;
                }

                console.log('Зареждане на таймлайн от:', url);
                const response = await fetch(url);
                const data = await response.json();

                if (!data.history || data.history.length < 2) {
                    alert('Няма достатъчно исторически данни за таймлайн. (Нужни са поне 2 точки)');
                    isTimelineMode = false;
                    return;
                }

                console.log(`Заредени ${data.history.length} точки за таймлайн`);
                timelineData = data.history;

                if (!timelineControls) {
                    timelineControls = createTimelineControls();
                }

                timelineControls.style.display = 'block';

                // Показваме целия маршрут на картата
                showFullTimeline();

                // Настройваме слайдера
                if (timelineSlider) {
                    timelineSlider.max = timelineData.length - 1;
                    timelineSlider.value = 0;
                }

                // Показваме първата точка
                showTimelinePoint(0);

                // Информация за таймлайна
                const totalDist = data.total_distance || 0;
                const infoEl = document.getElementById('timelineInfo');
                if (infoEl) {
                    const dateRange = timelineData.length > 0 ? 
                        `от: ${timelineData[0].recorded_at} до: ${timelineData[timelineData.length-1].recorded_at}` : '';
                    infoEl.innerHTML = `
                        📊 ${timelineData.length} точки | 
                        📏 Общо разстояние: ${totalDist.toFixed(2)} км | 
                        🕐 ${dateRange}
                    `;
                }

                document.getElementById('timelineProgress').textContent = '0%';
                debugTimelineData();

                // Актуализираме активния бутон
                document.querySelectorAll('.date-btn').forEach(btn => {
                    btn.classList.remove('active', 'ring-2', 'ring-offset-2', 'ring-emerald-500');
                });
                
                // Маркираме кой бутон е активен
                const btnText = date === 'today' ? 'Днес' : 
                               date === '2026-06-23' ? '23 юни 2026' :
                               date === '2026-06-24' ? '24 юни 2026' : 
                               'Цялото бягане';
                
                document.querySelectorAll('.date-btn').forEach(btn => {
                    if (btn.textContent.trim().includes(btnText) || 
                        (date === null && btn.textContent.includes('Цялото'))) {
                        btn.classList.add('active', 'ring-2', 'ring-offset-2', 'ring-emerald-500');
                    }
                });

            } catch (error) {
                console.error('Грешка при зареждане на таймлайн:', error);
                alert('Грешка при зареждане на историята за таймлайн: ' + error.message);
                isTimelineMode = false;
            }
        }

        function showTimelinePoint(index) {
            if (!timelineData || index < 0 || index >= timelineData.length) return;

            const point = timelineData[index];
            currentTimelineIndex = index;

            // Актуализираме позицията на бегача с fromTimeline = true
            updateRunnerPosition(point.lat, point.lng, point.distance_km, true);

            // Актуализираме информацията
            const progress = ((index + 1) / timelineData.length * 100);
            document.getElementById('timelineProgress').textContent = progress.toFixed(1) + '%';
            document.getElementById('timelineTime').textContent = point.time || '--:--:--';
            document.getElementById('timelineDistance').textContent = point.distance_km.toFixed(1) + ' км';

            // Актуализираме слайдера без да предизвикваме събитие
            if (timelineSlider) {
                timelineSlider.value = index;
            }

            // Добавяме информация за скоростта, ако е налична
            if (point.speed) {
                document.getElementById('timelineInfo').innerHTML = `
                    ⏱️ Точка ${index + 1} от ${timelineData.length} | 
                    🏃 Скорост: ${point.speed.toFixed(1)} км/ч | 
                    📏 Разстояние: ${point.distance_km.toFixed(1)} км
                `;
            }
        }

        function toggleTimelinePlay() {
            const playBtn = document.getElementById('playBtn');
            if (!playBtn) return;

            if (isPlayingTimeline) {
                // Спираме
                clearInterval(timelinePlayInterval);
                isPlayingTimeline = false;
                playBtn.innerHTML = '▶️ Възпроизвеждане';
                playBtn.className = 'bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition shadow';
            } else {
                if (!timelineData || timelineData.length < 2) {
                    alert('Няма заредени данни за таймлайн. Заредете история първо.');
                    return;
                }
                
                // Започваме
                isPlayingTimeline = true;
                playBtn.innerHTML = '⏸️ Пауза';
                playBtn.className = 'bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg transition shadow';

                let speed = parseInt(document.querySelector('.speed-btn.bg-blue-500')?.dataset.speed || 1);

                timelinePlayInterval = setInterval(() => {
                    if (currentTimelineIndex < timelineData.length - 1) {
                        showTimelinePoint(currentTimelineIndex + 1);
                    } else {
                        // Стигнахме края
                        clearInterval(timelinePlayInterval);
                        isPlayingTimeline = false;
                        playBtn.innerHTML = '▶️ Възпроизвеждане';
                        playBtn.className = 'bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition shadow';
                        alert('🎉 Таймлайнът завърши!');
                    }
                }, 1500 / speed);
            }
        }

        function resetTimeline() {
            if (isPlayingTimeline) {
                clearInterval(timelinePlayInterval);
                isPlayingTimeline = false;
                const playBtn = document.getElementById('playBtn');
                if (playBtn) {
                    playBtn.innerHTML = '▶️ Възпроизвеждане';
                    playBtn.className = 'bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition shadow';
                }
            }

            if (timelineData && timelineData.length > 0) {
                showTimelinePoint(0);
            }
        }

        function showFullTimeline() {
            if (!timelineData || timelineData.length < 2) return;

            const coords = timelineData.map(p => [p.lng, p.lat]);

            // Премахваме стария слой ако съществува
            if (map.getLayer('timeline-route')) {
                map.removeLayer('timeline-route');
            }
            if (map.getSource('timeline-route')) {
                map.removeSource('timeline-route');
            }

            // Добавяме пълния маршрут като линия
            map.addSource('timeline-route', {
                type: 'geojson',
                data: {
                    type: 'Feature',
                    geometry: {
                        type: 'LineString',
                        coordinates: coords
                    }
                }
            });

            map.addLayer({
                id: 'timeline-route',
                type: 'line',
                source: 'timeline-route',
                layout: {
                    'line-join': 'round',
                    'line-cap': 'round'
                },
                paint: {
                    'line-color': '#8e44ad',
                    'line-width': 3,
                    'line-opacity': 0.6,
                    'line-dasharray': [1, 2]
                }
            });

            // Центрираме картата върху целия маршрут
            try {
                const bounds = new maplibregl.LngLatBounds();
                coords.forEach(coord => bounds.extend(coord));
                map.fitBounds(bounds, {
                    padding: 50,
                    duration: 1000
                });
            } catch (e) {
                console.warn('Не може да се центрира картата:', e);
            }
        }

        function setTimelineSpeed(speed) {
            // Актуализираме активния бутон
            document.querySelectorAll('.speed-btn').forEach(btn => {
                btn.classList.remove('bg-blue-500', 'text-white');
                btn.classList.add('bg-gray-300');
            });

            const activeBtn = document.querySelector(`.speed-btn[data-speed="${speed}"]`);
            if (activeBtn) {
                activeBtn.classList.remove('bg-gray-300');
                activeBtn.classList.add('bg-blue-500', 'text-white');
            }

            // Ако възпроизвеждането е активно, рестартираме с новата скорост
            if (isPlayingTimeline) {
                clearInterval(timelinePlayInterval);
                const currentSpeed = speed;
                const playBtn = document.getElementById('playBtn');
                
                timelinePlayInterval = setInterval(() => {
                    if (currentTimelineIndex < timelineData.length - 1) {
                        showTimelinePoint(currentTimelineIndex + 1);
                    } else {
                        clearInterval(timelinePlayInterval);
                        isPlayingTimeline = false;
                        if (playBtn) {
                            playBtn.innerHTML = '▶️ Възпроизвеждане';
                            playBtn.className = 'bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition shadow';
                        }
                        alert('🎉 Таймлайнът завърши!');
                    }
                }, 1500 / currentSpeed);
            }
        }

        function closeTimeline() {
            // Спираме всички таймлайн процеси
            if (isPlayingTimeline) {
                clearInterval(timelinePlayInterval);
                isPlayingTimeline = false;
            }
            
            // Премахваме таймлайн слоевете
            if (map.getLayer('timeline-route')) {
                map.removeLayer('timeline-route');
            }
            if (map.getSource('timeline-route')) {
                map.removeSource('timeline-route');
            }
            
            // Скриваме контролите
            if (timelineControls) {
                timelineControls.style.display = 'none';
            }
            
            // Изчистваме данните
            timelineData = [];
            currentTimelineIndex = 0;
            
            // Връщаме се към реално проследяване
            isTimelineMode = false;
            
            // Връщаме се към реалната позиция
            fetch('/current-runner-position')
                .then(res => res.json())
                .then(data => {
                    updateRunnerPosition(parseFloat(data.lat), parseFloat(data.lng), parseFloat(data.distance));
                })
                .catch(err => console.error(err));
            
            // Премахваме активния клас от бутоните
            document.querySelectorAll('.date-btn').forEach(btn => {
                btn.classList.remove('active', 'ring-2', 'ring-offset-2', 'ring-emerald-500');
            });
        }

        function debugTimelineData() {
            console.log('Timeline Data:', timelineData);
            console.log('Total points:', timelineData.length);
            if (timelineData.length > 0) {
                console.log('First point:', timelineData[0]);
                console.log('Last point:', timelineData[timelineData.length - 1]);
                console.log('Sample points:', timelineData.slice(0, 5));
            }
        }

        // ==================== ИНИЦИАЛИЗАЦИЯ ====================

        document.addEventListener('DOMContentLoaded', () => {
            setTimeout(() => {
                initMap();
            }, 300);
        });
    </script>
</body>

</html>