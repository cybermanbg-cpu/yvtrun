<div class="bg-gradient-to-r from-red-600 to-red-800 rounded-lg p-6 text-white">
    <h3 class="text-xl font-bold mb-4">🏃‍♂️ Контролен панел на бегача</h3>
    
    @if($message)
        <div class="mb-4 bg-green-500 p-2 rounded text-center">
            {{ $message }}
        </div>
    @endif
    
    <div class="grid md:grid-cols-2 gap-4 mb-4">
        <div>
            <label class="block text-sm mb-1">📍 Вземи текущата локация</label>
            <button onclick="getLocation()" class="bg-blue-500 hover:bg-blue-600 px-4 py-2 rounded w-full transition">
                📍 Вземи GPS позиция
            </button>
        </div>
        <div>
            <label class="block text-sm mb-1">📏 Изминати километри (0-133)</label>
            <input type="range" wire:model="distance" min="0" max="133" step="0.5" class="w-full">
            <input type="number" wire:model="distance" step="0.5" class="w-full mt-2 px-3 py-2 rounded text-black">
        </div>
    </div>
    
    <div class="grid md:grid-cols-2 gap-4 mb-4">
        <div>
            <label class="block text-sm mb-1">🌐 Геогр. ширина (lat)</label>
            <input type="text" wire:model="lat" class="w-full px-3 py-2 rounded text-black">
        </div>
        <div>
            <label class="block text-sm mb-1">🌐 Геогр. дължина (lng)</label>
            <input type="text" wire:model="lng" class="w-full px-3 py-2 rounded text-black">
        </div>
    </div>
    
    <button wire:click="updateLocation" class="w-full bg-green-600 hover:bg-green-700 py-2 rounded font-bold transition">
        🚀 Обнови локацията на картата
    </button>
    
    <div class="mt-4 text-sm text-gray-200 bg-black/30 p-3 rounded">
        <p>📊 Текущ напредък: <strong>{{ number_format($run->distance_covered_km ?? 0, 1) }}</strong> / 133 км</p>
        <p>🎯 Оставащи: <strong>{{ number_format(133 - ($run->distance_covered_km ?? 0), 1) }}</strong> км</p>
        <p class="text-xs mt-1 opacity-75">📍 Последна позиция: {{ $run->current_lat ?? '0' }}, {{ $run->current_lng ?? '0' }}</p>
    </div>
</div>

<script>
    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition((position) => {
                @this.set('lat', position.coords.latitude);
                @this.set('lng', position.coords.longitude);
                
                // Автоматично обновяване след вземане на локация
                @this.updateLocation();
            }, (error) => {
                alert('Грешка: ' + error.message);
            });
        } else {
            alert('Браузърът не поддържа геолокация');
        }
    }
    
    // Слушаме за събития
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('get-location', () => {
            getLocation();
        });
    });
</script>