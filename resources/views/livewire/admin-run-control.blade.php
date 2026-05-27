<div class="bg-gradient-to-r from-gray-800 to-gray-900 rounded-lg p-6 text-white">
    <h3 class="text-xl font-bold mb-4">🎮 Админ контрол - Бягане на живо</h3>
    
    <form wire:submit.prevent="updatePosition" class="space-y-4">
        <div>
            <label class="block text-sm mb-2">Изминати километри (0-133)</label>
            <input type="range" wire:model="distance" min="0" max="133" step="0.1" class="w-full">
            <input type="number" wire:model="distance" step="0.1" class="mt-2 w-full px-3 py-2 bg-gray-700 rounded">
        </div>
        
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm mb-2">Геогр. ширина (lat)</label>
                <input type="text" wire:model="lat" class="w-full px-3 py-2 bg-gray-700 rounded">
            </div>
            <div>
                <label class="block text-sm mb-2">Геогр. дължина (lng)</label>
                <input type="text" wire:model="lng" class="w-full px-3 py-2 bg-gray-700 rounded">
            </div>
        </div>
        
        <button type="submit" class="w-full bg-green-600 hover:bg-green-700 py-2 rounded font-bold">
            📍 Обнови позицията
        </button>
        
        @if(session()->has('message'))
            <div class="bg-green-500 text-white p-2 rounded text-center">
                {{ session('message') }}
            </div>
        @endif
    </form>
    
    <div class="mt-4 text-sm text-gray-400">
        <p>Текуща позиция: {{ number_format($distance, 1) }} км от Ямбол</p>
        <p>Следваща точка: {{ $run->nextCheckpoint()->name ?? 'Финал!' }}</p>
    </div>
</div>