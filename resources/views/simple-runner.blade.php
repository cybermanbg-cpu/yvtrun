<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>🏃‍♂️ Бегач панел</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4 max-w-2xl">
        <div class="text-center mb-6">
            <a href="/" class="text-blue-600 hover:underline">← Назад към картата</a>
            <h1 class="text-3xl font-bold text-red-600 mt-2">🏃‍♂️ Бегач панел</h1>
            <p class="text-gray-600">Сподели текущата си локация (за тест)</p>
        </div>
        
        <div class="bg-white rounded-lg shadow-lg p-6">
            <button onclick="getLocation()" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 rounded-lg mb-4 transition">
                📍 Вземи текущата GPS локация
            </button>
            
            <div class="border-t pt-4">
                <h3 class="font-bold mb-2">✏️ Ръчно въвеждане:</h3>
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-bold">Ширина (lat)</label>
                        <input type="text" id="lat" class="w-full border rounded px-3 py-2" value="42.4833">
                    </div>
                    <div>
                        <label class="block text-sm font-bold">Дължина (lng)</label>
                        <input type="text" id="lng" class="w-full border rounded px-3 py-2" value="26.5000">
                    </div>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-bold">Изминати км</label>
                    <input type="number" id="distance" class="w-full border rounded px-3 py-2" value="0" step="1">
                </div>
                <button onclick="updateLocation()" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-2 rounded-lg transition">
                    🚀 Обнови локацията
                </button>
            </div>
            
            <div id="status" class="mt-4 p-3 rounded hidden"></div>
        </div>
    </div>
    
    <script>
        function getLocation() {
            if (!navigator.geolocation) {
                alert('Браузърът не поддържа геолокация');
                return;
            }
            
            showStatus('⏳ Вземане на локация...', 'blue');
            
            navigator.geolocation.getCurrentPosition(
                function(pos) {
                    document.getElementById('lat').value = pos.coords.latitude;
                    document.getElementById('lng').value = pos.coords.longitude;
                    showStatus('✅ Локацията е взета! Натисни "Обнови"', 'green');
                },
                function(err) {
                    showStatus('❌ Грешка: ' + err.message, 'red');
                }
            );
        }
        
        function updateLocation() {
            const lat = parseFloat(document.getElementById('lat').value);
            const lng = parseFloat(document.getElementById('lng').value);
            const distance = parseFloat(document.getElementById('distance').value);
            
            fetch('/update-runner-location', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ lat: lat, lng: lng, distance: distance })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    showStatus('✅ Локацията е обновена!', 'green');
                } else {
                    showStatus('❌ Грешка', 'red');
                }
            })
            .catch(err => showStatus('❌ Грешка: ' + err, 'red'));
        }
        
        function showStatus(msg, color) {
            const div = document.getElementById('status');
            div.className = 'mt-4 p-3 rounded text-center ';
            div.classList.add(color === 'green' ? 'bg-green-100 text-green-700' : (color === 'red' ? 'bg-red-100 text-red-700' : 'bg-blue-100 text-blue-700'));
            div.innerHTML = msg;
            div.classList.remove('hidden');
            setTimeout(() => div.classList.add('hidden'), 3000);
        }
    </script>
</body>
</html>