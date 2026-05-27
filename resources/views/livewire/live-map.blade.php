<div wire:poll.2s="refreshLocation">
    <div class="bg-white rounded-lg shadow-lg p-4">
        <div id="map" style="height: 500px; width: 100%;"></div>

        <div class="mt-4">
            <div class="bg-gradient-to-r from-red-500 to-orange-500 rounded-lg p-4 text-white">
                <h3 class="font-bold text-xl mb-2">📊 Напредък</h3>
                <div class="flex justify-between items-center mb-2">
                    <span>Текуща позиция:</span>
                    <span class="font-mono text-2xl font-bold">{{ number_format($distanceCovered, 1) }} км</span>
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
</div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    let map = null;
    let runnerMarker = null;
    let isInitialized = false;
    
    function initMap() {
        if (isInitialized) return;
        
        const mapElement = document.getElementById('map');
        if (!mapElement || typeof L === 'undefined') {
            setTimeout(initMap, 200);
            return;
        }
        
        // Вземи текущите координати от Livewire
        const runnerLat = {{ $runnerLat }};
        const runnerLng = {{ $runnerLng }};
        
        console.log('Инициализация на картата с координати:', runnerLat, runnerLng);
        
        // Създаване на картата с център текущата локация
        map = L.map('map').setView([runnerLat, runnerLng], 12);
        
        L.tileLayer('https://{s}.tile-cyclosm.openstreetmap.fr/cyclosm/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);
        
        // Добави маркер за текущата позиция
        updateRunnerMarker();
        
        isInitialized = true;
        console.log('Картата е инициализирана успешно');
    }
    
    function updateRunnerMarker() {
        if (!map) {
            console.log('Картата не е готова');
            return;
        }
        
        const lat = parseFloat({{ $runnerLat }});
        const lng = parseFloat({{ $runnerLng }});
        const distance = parseFloat({{ $distanceCovered }});
        
        console.log('Обновяване на маркер:', lat, lng);
        
        // Премахване на стария маркер
        if (runnerMarker) {
            map.removeLayer(runnerMarker);
        }
        
        // Създаване на нов маркер
        const runnerIcon = L.divIcon({
            className: 'runner-marker',
            html: '🏃‍♂️',
            iconSize: [40, 40]
        });
        
        runnerMarker = L.marker([lat, lng], { icon: runnerIcon })
            .bindPopup(`🏃‍♂️ Текуща локация<br>Ширина: ${lat.toFixed(4)}<br>Дължина: ${lng.toFixed(4)}`)
            .addTo(map);
        
        // Центриране на картата
        map.setView([lat, lng], 12);
    }
    
    // Стартиране на картата
    document.addEventListener('DOMContentLoaded', () => {
        setTimeout(initMap, 500);
    });
    
    // Слушане за Livewire ъпдейти
    document.addEventListener('livewire:load', function() {
        Livewire.on('location-updated', function() {
            console.log('Получено събитие за обновяване');
            setTimeout(updateRunnerMarker, 100);
        });
    });
</script>