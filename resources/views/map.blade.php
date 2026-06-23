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

        <!-- 📊 Секция за даренията -->
        {{-- <div class="mb-8">
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
        </div> --}}

        <!-- Action Buttons -->
        <!-- Бутони за управление на картата -->
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

            <button onclick="clearHistory()"
                class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition shadow">
                🗑️ Изчисти историята
            </button>

            <button onclick="resetMapView()"
                class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg transition shadow">
                🗺️ Цялата карта
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
                <span>📍 Нова Загора (30км)</span>
                <span>📍 Гурково (70км)</span>
                <span>📍 Елена (90км)</span>
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

        <!-- 🤝 Секция за доброволци -->
        {{-- <div class="mt-8 mb-8">
            <div class="bg-gradient-to-r from-blue-500 to-blue-700 rounded-xl shadow-lg p-6 text-white">
                <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                    <div class="text-center md:text-left">
                        <p class="text-sm uppercase tracking-wide opacity-90">Нашият екип</p>
                        <p class="text-4xl font-bold">{{ $volunteersCount }}</p>
                        <p class="text-sm opacity-90">🤝 записани доброволци</p>
                    </div>
                    <div>
                        <a href="{{ route('volunteers.index') }}"
                            class="bg-white text-blue-600 hover:bg-blue-50 font-bold py-2 px-6 rounded-full transition">
                            🤝 Стани доброволец
                        </a>
                    </div>
                </div>
            </div>
        </div> --}}
    </div>


    <script src="https://unpkg.com/maplibre-gl@4.0.0/dist/maplibre-gl.js"></script>

    <script>
        let map = null;
        let runnerMarker = null;
        let trailPoints = [];
        let historyLine = null;

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

        function updateRunnerPosition(lat, lng, distance) {
            if (!map) return;

            document.getElementById('coordDisplay').innerHTML =
                `📍 ${lat.toFixed(6)}, ${lng.toFixed(6)} | 🛤️ Точки: ${trailPoints.length}`;
            document.getElementById('distanceDisplay').innerHTML = distance.toFixed(1) + ' / 133 км';
            document.getElementById('progressBar').style.width = Math.min((distance / 133 * 100), 100) + '%';

            // Добавяне на точка към текущата следа
            const newPoint = [lat, lng];
            if (trailPoints.length === 0 ||
                Math.hypot(trailPoints[trailPoints.length - 1][0] - lat, trailPoints[trailPoints.length - 1][1] - lng) >
                0.00008) {
                trailPoints.push(newPoint);
            }

            const trailCoordinates = trailPoints.map(p => [p[1], p[0]]);

            if (map.getSource('trail')) {
                map.getSource('trail').setData({
                    type: 'Feature',
                    geometry: {
                        type: 'LineString',
                        coordinates: trailCoordinates
                    }
                });
            } else {
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
                    paint: {
                        'line-color': '#e74c3c',
                        'line-width': 6,
                        'line-opacity': 0.85,
                        'line-join': 'round',
                        'line-cap': 'round'
                    }
                });
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
                    updateRunnerPosition(parseFloat(data.lat), parseFloat(data.lng), parseFloat(data.distance));
                })
                .catch(err => console.error(err));

            // Обновяване на всеки 2 секунди
            setInterval(() => {
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

                if (map.getSource('history-line')) {
                    map.getSource('history-line').setData({
                        type: 'Feature',
                        geometry: {
                            type: 'LineString',
                            coordinates: coords
                        }
                    });
                } else {
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
                        paint: {
                            'line-color': '#8e44ad',
                            'line-width': 4.5,
                            'line-opacity': 0.75,
                            'line-dasharray': [1, 2]
                        }
                    });
                }

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

        document.addEventListener('DOMContentLoaded', () => {
            setTimeout(initMap, 300);
        });
    </script>
</body>

</html>
