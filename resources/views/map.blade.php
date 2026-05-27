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
                    <h3 class="font-bold text-xl mb-2">📊 Напредък</h3>
                    <div class="flex justify-between items-center mb-2">
                        <span>Изминати км:</span>
                        <span class="font-mono text-2xl font-bold" id="distanceDisplay">0 / 133 км</span>
                    </div>
                    <div class="w-full bg-white/30 rounded-full h-4 overflow-hidden">
                        <div class="bg-yellow-400 h-4 rounded-full" id="progressBar" style="width: 0%"></div>
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
                <span>📍 Твърдица (55км)</span>
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

                <!-- ЛАЙФ ВИДЕО -->
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

                <!-- МИНАЛИ ВИДЕА -->
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
                                            {{ $video->created_at->format('d.m.Y H:i') }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="mt-8 flex flex-wrap gap-4 justify-center">
            <a href="{{ route('volunteers.index') }}"
                class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 px-6 rounded-full transition shadow-lg transform hover:scale-105">
                🤝 Стани доброволец
            </a>
            <a href="{{ route('donations.index') }}"
                class="bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-6 rounded-full transition shadow-lg transform hover:scale-105">
                ❤️ Дари сега
            </a>
            <a href="/simple-runner"
                class="bg-purple-500 hover:bg-purple-600 text-white font-bold py-3 px-6 rounded-full transition shadow-lg transform hover:scale-105">
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
                        <a href="{{ route('volunteers.index') }}"
                            class="bg-white text-blue-600 hover:bg-blue-50 font-bold py-2 px-6 rounded-full transition">
                            🤝 Стани доброволец
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        let map = null;
        let runnerMarker = null;
        let runnerCircle = null;

        function initMap() {
            map = L.map('map').setView([42.4833, 26.5000], 8);

            L.tileLayer('https://{s}.tile.openstreetmap.fr/hot/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap'
            }).addTo(map);

            // Контролни точки
            const checkpoints = @json($checkpoints);
            checkpoints.forEach(cp => {
                const emoji = cp.distance_km === 0 ? '🏁' : (cp.distance_km === 133 ? '🏆' : '📍');
                L.marker([parseFloat(cp.lat), parseFloat(cp.lng)], {
                    icon: L.divIcon({
                        html: emoji,
                        iconSize: [28, 28]
                    })
                }).bindPopup(`${cp.name}<br>${cp.distance_km} км`).addTo(map);
            });

            startTracking();
        }

        function updateRunnerPosition(lat, lng, distance) {
            if (!map) return;

            console.log('📍 Преместване на:', lat, lng);

            // Премахване на старите елементи
            if (runnerMarker) {
                map.removeLayer(runnerMarker);
            }
            if (runnerCircle) {
                map.removeLayer(runnerCircle);
            }

            // Хубав червен пип (pin marker)
            const redPinIcon = L.divIcon({
                className: 'custom-pin',
                html: '<div style="background-color: #e74c3c; width: 20px; height: 20px; border-radius: 50% 50% 50% 0; border: 3px solid white; transform: rotate(-45deg); box-shadow: 0 2px 5px rgba(0,0,0,0.3);"></div><div style="position: absolute; top: 5px; left: 7px; width: 6px; height: 6px; background-color: white; border-radius: 50%;"></div>',
                iconSize: [20, 20],
                popupAnchor: [0, -15]
            });

            runnerMarker = L.marker([lat, lng], {
                    icon: redPinIcon
                })
                .bindPopup(`
                <div style="text-align: center;">
                    <b>🏃‍♂️ БЕГАЧЪТ Е ТУК!</b><br>
                    📍 ${lat.toFixed(6)}, ${lng.toFixed(6)}<br>
                    📏 ${distance.toFixed(1)} / 133 км
                </div>
            `)
                .addTo(map);

            // Червен кръг около пипа (радиус 50 метра)
            runnerCircle = L.circle([lat, lng], {
                color: '#e74c3c',
                fillColor: '#e74c3c',
                fillOpacity: 0.15,
                radius: 50,
                weight: 2
            }).addTo(map);

            // Центриране
            map.setView([lat, lng], 16);

            // Обнови дисплея
            document.getElementById('coordDisplay').innerHTML = `📍 ${lat.toFixed(6)}, ${lng.toFixed(6)}`;
            document.getElementById('distanceDisplay').innerHTML = distance.toFixed(1) + ' / 133 км';
            document.getElementById('progressBar').style.width = (distance / 133 * 100) + '%';
        }

        function startTracking() {
            // Първо зареждане
            fetch('/current-runner-position')
                .then(res => res.json())
                .then(data => {
                    updateRunnerPosition(parseFloat(data.lat), parseFloat(data.lng), parseFloat(data.distance));
                })
                .catch(err => console.error('Грешка:', err));

            // Периодично обновяване на всяка 1 секунда
            setInterval(() => {
                fetch('/current-runner-position')
                    .then(res => res.json())
                    .then(data => {
                        updateRunnerPosition(parseFloat(data.lat), parseFloat(data.lng), parseFloat(data
                            .distance));
                    })
                    .catch(err => console.error('Грешка:', err));
            }, 1000);
        }

        document.addEventListener('DOMContentLoaded', () => {
            setTimeout(initMap, 100);
        });
    </script>

    <style>
        .custom-pin {
            background: none;
            border: none;
        }

        .custom-pin div:first-child {
            animation: pulse 1.5s ease-in-out infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                transform: rotate(-45deg) scale(1);
                opacity: 1;
            }

            50% {
                transform: rotate(-45deg) scale(1.3);
                opacity: 0.8;
            }
        }
    </style>
</body>

</html>
