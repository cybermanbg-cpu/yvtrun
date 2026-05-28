<x-filament-panels::page>
    <div class="space-y-6">
        {{ $this->form }}
        
        <div class="bg-white rounded-lg shadow p-4">
            <h3 class="text-lg font-bold mb-2">🗺️ Карта на локацията</h3>
            <div id="map" style="height: 400px; width: 100%;"></div>
        </div>
    </div>
    
    <link href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" rel="stylesheet" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(() => {
                const lat = {{ $record->lat }};
                const lng = {{ $record->lng }};
                
                const map = L.map('map').setView([lat, lng], 13);
                
                L.tileLayer('https://{s}.tile.openstreetmap.fr/hot/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap'
                }).addTo(map);
                
                L.marker([lat, lng])
                    .bindPopup(`
                        <b>📍 Локация</b><br>
                        📏 ${ {{ $record->distance_km }} } км от старта<br>
                        🕐 ${ {{ $record->recorded_at }} }
                    `)
                    .addTo(map);
            }, 500);
        });
    </script>
</x-filament-panels::page>