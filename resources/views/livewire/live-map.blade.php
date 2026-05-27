<div>
    <div class="bg-white rounded-lg shadow-lg p-4">
        <div id="map" style="height: 500px; width: 100%;"></div>

        <div class="mt-4">
            <div class="bg-gradient-to-r from-red-500 to-orange-500 rounded-lg p-4 text-white">
                <h3 class="font-bold text-xl mb-2">📊 Напредък на бягането</h3>
                <div class="flex justify-between items-center mb-2">
                    <span>Изминати километри:</span>
                    <span class="font-mono text-2xl font-bold">{{ number_format($distanceCovered, 1) }} / 133 км</span>
                </div>
                <div class="w-full bg-white/30 rounded-full h-4 overflow-hidden">
                    <div class="bg-yellow-400 h-4 rounded-full transition-all duration-500"
                        style="width: {{ ($distanceCovered / 133) * 100 }}%"></div>
                </div>
                <div class="flex justify-between mt-2 text-sm">
                    <span>🏁 Ямбол</span>
                    <span>📍 Нова Загора (30км)</span>
                    <span>📍 Твърдица (55км)</span>
                    <span>📍 Елена (90км)</span>
                    <span>📍 Дебелец (120км)</span>
                    <span>🏆 В. Търново</span>
                </div>
            </div>
        </div>
    </div>

    <style>
        .runner-marker {
            background: none;
            border: none;
            font-size: 32px;
            filter: drop-shadow(2px 2px 2px rgba(0, 0, 0, 0.3));
            animation: bounce 1s infinite;
        }

        @keyframes bounce {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }
    </style>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            // Проверка дали картата вече не е инициализирана
            if (document.querySelector('#map')._leaflet_id) {
                return;
            }

            // Координати
            const runnerLat = {{ $runnerLat }};
            const runnerLng = {{ $runnerLng }};
            const checkpoints = @json($checkpoints);

            // Инициализация на картата
            const map = L.map('map').setView([runnerLat, runnerLng], 8);

            // Вариант Б: Humanitarian OpenStreetMap (Hot style) - добър за България
            L.tileLayer('https://{s}.tile-cyclosm.openstreetmap.fr/cyclosm/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
                maxZoom: 20
            }).addTo(map);

            // Добави маркерите за контролните точки
            checkpoints.forEach(cp => {
                const iconName = cp.distance_km === 0 ? '🏁' : (cp.distance_km === 133 ? '🏆' :
                    '📍');
                const popupText = '<b>' + cp.name + '</b><br>📍 ' + cp.distance_km +
                    ' км от старта<br>' +
                    (cp.distance_km === 0 ? 'Начало' : (cp.distance_km === 133 ? 'ФИНАЛ!' :
                        'Контролна точка'));

                L.marker([parseFloat(cp.lat), parseFloat(cp.lng)])
                    .bindPopup(popupText)
                    .addTo(map);
            });

            // Добави маркер за бягащия
            const runnerIcon = L.divIcon({
                className: 'runner-marker',
                html: '🏃‍♂️',
                iconSize: [40, 40],
                popupAnchor: [0, -20]
            });

            L.marker([runnerLat, runnerLng], {
                    icon: runnerIcon
                })
                .bindPopup('<b>🏃‍♂️ Бягащият е тук!</b>')
                .addTo(map);

        }, 100);
    });
</script>
