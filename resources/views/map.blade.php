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

        /* Стилове за таблицата с локации */
        #locationTableBody tr {
            transition: background-color 0.3s ease;
        }

        #locationTableBody tr:hover {
            background-color: #f3f4f6 !important;
        }

        #locationTableBody tr.bg-yellow-100 {
            background-color: #fef3c7 !important;
        }

        #locationTableBody tr.bg-green-50 {
            background-color: #f0fdf4 !important;
        }

        /* Скрол на таблицата */
        #locationListContainer {
            max-height: 600px;
            overflow-y: auto;
        }

        #locationListContainer table {
            border-collapse: collapse;
        }

        #locationListContainer thead {
            position: sticky;
            top: 0;
            z-index: 10;
            background: white;
        }

        /* Анимация за нови записи */
        @keyframes fadeInRow {
            from {
                opacity: 0;
                transform: translateX(-10px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        #locationTableBody tr {
            animation: fadeInRow 0.3s ease;
        }

        #locationTableBody tr:nth-child(1) {
            animation-delay: 0s;
        }
        #locationTableBody tr:nth-child(2) {
            animation-delay: 0.05s;
        }
        #locationTableBody tr:nth-child(3) {
            animation-delay: 0.1s;
        }
        #locationTableBody tr:nth-child(4) {
            animation-delay: 0.15s;
        }
        #locationTableBody tr:nth-child(5) {
            animation-delay: 0.2s;
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

            {{-- <button onclick="clearTrail()"
                class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition shadow">
                🧹 Изчисти следата
            </button> --}}

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
                <span>📍 Сливен (30км)</span>
                <span>📍 Гурково (70км)</span>
                <span>📍 Прохода на Републиката (90км)</span>
                <span>📍 Дебелец (120км)</span>
                <span>🏆 В. Търново (133км)</span>
            </div>
        </div>

        <!-- ========== 📋 СПИСЪК С ЛОКАЦИИ ========== -->
        <div class="bg-white rounded-lg shadow-lg p-4 mb-8">
            <div class="flex justify-between items-center mb-4 flex-wrap gap-2">
                <h2 class="text-2xl font-bold flex items-center gap-2">
                    <span class="text-blue-600">📍</span>
                    История на локациите
                    <span class="text-sm font-normal text-gray-500 ml-2">
                        ({{ $totalLocations ?? 0 }} записа)
                    </span>
                </h2>
                <div class="flex gap-2 flex-wrap">
                    <button onclick="toggleLocationList()"
                        class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition text-sm">
                        👁️ Скрий/Покажи
                    </button>
                    <button onclick="exportLocations()"
                        class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg transition text-sm">
                        📥 Експорт
                    </button>
                    {{-- <button onclick="refreshLocations()"
                        class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg transition text-sm">
                        🔄 Обнови
                    </button> --}}
                </div>
            </div>

            <!-- Статистики -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-4">
                <div class="bg-gray-50 rounded-lg p-3 text-center">
                    <p class="text-xs text-gray-500">Общо точки</p>
                    <p class="text-2xl font-bold text-blue-600">{{ $totalLocations ?? 0 }}</p>
                </div>
                <div class="bg-gray-50 rounded-lg p-3 text-center">
                    <p class="text-xs text-gray-500">Общо км</p>
                    <p class="text-2xl font-bold text-green-600">133.00 +</p>
                </div>
                <div class="bg-gray-50 rounded-lg p-3 text-center">
                    <p class="text-xs text-gray-500">Последна скорост</p>
                    <p class="text-2xl font-bold text-purple-600">
                        4.0
                        <span class="text-sm font-normal">км/ч</span>
                    </p>
                </div>
                <div class="bg-gray-50 rounded-lg p-3 text-center">
                    <p class="text-xs text-gray-500">Последно обновяване</p>
                    <p class="text-sm font-bold text-gray-700">
                        {{ isset($lastLocation) ? $lastLocation->recorded_at->format('H:i:s') : '--:--' }}
                    </p>
                </div>
            </div>

            <!-- Таблица със списък -->
            <div id="locationListContainer" class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 border-b">
                        <tr>
                            <th class="px-4 py-2 text-left font-semibold text-gray-600">#</th>
                            <th class="px-4 py-2 text-left font-semibold text-gray-600">📍 Координати</th>
                            <th class="px-4 py-2 text-left font-semibold text-gray-600">📏 Км</th>
                            <th class="px-4 py-2 text-left font-semibold text-gray-600">🏃 Скорост</th>
                            <th class="px-4 py-2 text-left font-semibold text-gray-600">🕐 Час</th>
                            <th class="px-4 py-2 text-left font-semibold text-gray-600">📱 Батерия</th>
                            <th class="px-4 py-2 text-left font-semibold text-gray-600">🎯 Точност</th>
                        </tr>
                    </thead>
                    <tbody id="locationTableBody">
                        @forelse($locations ?? [] as $index => $location)
                            <tr class="border-b hover:bg-gray-50 transition {{ $loop->first ? 'bg-blue-50' : '' }}">
                                <td class="px-4 py-2 text-gray-500">{{ $loop->iteration }}</td>
                                <td class="px-4 py-2 font-mono text-xs">
                                    <span class="text-blue-600">{{ number_format($location->lat, 6) }}</span>,
                                    <span class="text-green-600">{{ number_format($location->lng, 6) }}</span>
                                    <button onclick="centerOnLocation({{ $location->lat }}, {{ $location->lng }})"
                                        class="ml-1 text-blue-500 hover:text-blue-700 text-xs" title="Центрирай картата">
                                        🎯
                                    </button>
                                </td>
                                <td
                                    class="px-4 py-2 font-bold {{ ($location->distance_km ?? 0) >= 100 ? 'text-red-600' : (($location->distance_km ?? 0) >= 50 ? 'text-orange-500' : 'text-gray-700') }}">
                                    {{ number_format($location->distance_km ?? 0, 1) }}
                                </td>
                                <td class="px-4 py-2">
                                    {{ isset($location->speed) ? number_format($location->speed, 1) : '--' }}
                                    <span class="text-xs text-gray-400">км/ч</span>
                                </td>
                                <td class="px-4 py-2 text-gray-600">
                                    {{ $location->recorded_at->format('H:i:s') }}
                                    <span
                                        class="text-xs text-gray-400">{{ $location->recorded_at->format('d.m') }}</span>
                                </td>
                                <td class="px-4 py-2">
                                    @if (isset($location->battery))
                                        <div class="flex items-center gap-1">
                                            <span class="text-sm">{{ number_format($location->battery, 0) }}%</span>
                                            <div class="w-8 h-3 bg-gray-200 rounded-full overflow-hidden">
                                                <div class="h-full bg-green-500 rounded-full"
                                                    style="width: {{ $location->battery }}%"></div>
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-gray-400">--</span>
                                    @endif
                                </td>
                                <td class="px-4 py-2 text-gray-500">
                                    @if (isset($location->accuracy))
                                        {{ $location->accuracy }}м
                                    @else
                                        --
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-8 text-center text-gray-400">
                                    📭 Няма записани локации все още
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Пагинация -->
                @if (isset($locations) && $locations instanceof \Illuminate\Pagination\LengthAwarePaginator)
                    <div class="mt-4">
                        {{ $locations->links() }}
                    </div>
                @endif
            </div>

            <!-- Бутон за превъртане до най-новата локация -->
            <div class="mt-3 flex gap-2 flex-wrap">
                <button onclick="scrollToLatest()"
                    class="bg-purple-500 hover:bg-purple-600 text-white px-4 py-2 rounded-lg transition text-sm">
                    ⬇️ Към най-новата
                </button>
                <button onclick="scrollToTop()"
                    class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition text-sm">
                    ⬆️ Най-горе
                </button>
                <button onclick="centerOnLastLocation()"
                    class="bg-indigo-500 hover:bg-indigo-600 text-white px-4 py-2 rounded-lg transition text-sm">
                    🎯 Последна локация
                </button>
            </div>
        </div>

        <!-- 🎥 YouTube Видеа секция -->
        <div class="mb-8">
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-2xl font-bold mb-4 flex items-center gap-2">
                    <span class="text-red-600">🎥</span>
                    Видео от бягането
                </h2>

                @if (isset($liveVideo) && $liveVideo)
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

                @if (isset($pastVideos) && $pastVideos->count() > 0)
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
                const checkpoints = @json($checkpoints ?? []);
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
                if (routePoints.length > 0) {
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
                }

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

        // ==================== ФУНКЦИИ ЗА СПИСЪКА ====================

        // Скриване/показване на списъка
        function toggleLocationList() {
            const container = document.getElementById('locationListContainer');
            if (container.style.display === 'none') {
                container.style.display = 'block';
            } else {
                container.style.display = 'none';
            }
        }

        // Центриране на картата върху конкретна локация
        function centerOnLocation(lat, lng) {
            if (map) {
                map.flyTo({
                    center: [lng, lat],
                    zoom: 16,
                    duration: 1000
                });

                // Маркираме реда в таблицата
                document.querySelectorAll('#locationTableBody tr').forEach(row => {
                    row.classList.remove('bg-yellow-100');
                });

                // Намираме реда с тази локация (сравнение с плаваща запетая)
                const rows = document.querySelectorAll('#locationTableBody tr');
                rows.forEach(row => {
                    const cells = row.querySelectorAll('td');
                    if (cells.length >= 2) {
                        const coordText = cells[1].textContent.trim();
                        const match = coordText.match(/([\d.]+),\s*([\d.]+)/);
                        if (match) {
                            const rowLat = parseFloat(match[1]);
                            const rowLng = parseFloat(match[2]);
                            if (Math.abs(rowLat - lat) < 0.0001 && Math.abs(rowLng - lng) < 0.0001) {
                                row.classList.add('bg-yellow-100');
                                row.scrollIntoView({
                                    behavior: 'smooth',
                                    block: 'center'
                                });
                            }
                        }
                    }
                });
            }
        }

        // Центриране върху последната локация от списъка
        function centerOnLastLocation() {
            const rows = document.querySelectorAll('#locationTableBody tr');
            if (rows.length > 0) {
                const cells = rows[0].querySelectorAll('td');
                if (cells.length >= 2) {
                    const coordText = cells[1].textContent.trim();
                    const match = coordText.match(/([\d.]+),\s*([\d.]+)/);
                    if (match) {
                        const lat = parseFloat(match[1]);
                        const lng = parseFloat(match[2]);
                        centerOnLocation(lat, lng);
                    }
                }
            }
        }

        // Превъртане до най-новата локация
        function scrollToLatest() {
            const container = document.getElementById('locationListContainer');
            if (container) {
                const rows = container.querySelectorAll('tbody tr');
                if (rows.length > 0) {
                    rows[0].scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                    rows[0].classList.add('bg-green-50');
                    setTimeout(() => {
                        rows[0].classList.remove('bg-green-50');
                    }, 2000);
                }
            }
        }

        // Превъртане до началото
        function scrollToTop() {
            const container = document.getElementById('locationListContainer');
            if (container) {
                container.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        }

        // Обновяване на списъка
        function refreshLocations() {
            location.reload();
        }

        // Експорт на локациите в CSV
        function exportLocations() {
            const rows = document.querySelectorAll('#locationTableBody tr');
            if (rows.length === 0) {
                alert('Няма данни за експорт.');
                return;
            }

            let csv = '#'; // Заглавия
            csv += 'Lat,Lng,Distance (km),Speed (km/h),Recorded At,Battery (%),Accuracy (m)\n';

            rows.forEach(row => {
                const cells = row.querySelectorAll('td');
                if (cells.length >= 7) {
                    const coords = cells[1].textContent.trim().replace(/\s+/g, ' ').split(' ');
                    const lat = coords[0] || '';
                    const lng = coords[2] || '';
                    const distance = cells[2].textContent.trim();
                    const speed = cells[3].textContent.trim().replace('км/ч', '').trim();
                    const time = cells[4].textContent.trim();
                    const battery = cells[5].textContent.trim().replace('%', '').trim();
                    const accuracy = cells[6].textContent.trim().replace('м', '').trim();

                    csv += `${lat},${lng},${distance},${speed},${time},${battery},${accuracy}\n`;
                }
            });

            // Създаване и изтегляне на CSV файл
            const blob = new Blob([csv], {
                type: 'text/csv;charset=utf-8;'
            });
            const link = document.createElement('a');
            link.href = URL.createObjectURL(blob);
            link.download = `locations_${new Date().toISOString().slice(0,10)}.csv`;
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            URL.revokeObjectURL(link.href);
        }

        // ==================== ИНИЦИАЛИЗАЦИЯ ====================
        document.addEventListener('DOMContentLoaded', function() {
            // Маркираме първия ред (най-нов) със специален клас
            const firstRow = document.querySelector('#locationTableBody tr');
            if (firstRow) {
                firstRow.classList.add('border-l-4', 'border-blue-500');
            }
            
            // Стартиране на картата
            setTimeout(initMap, 300);
        });
    </script>
</body>

</html>