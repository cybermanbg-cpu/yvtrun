<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>🏃‍♂️ Бегач панел - YVTRun</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4 max-w-2xl">
        <div class="text-center mb-6">
            <a href="/" class="text-blue-600 hover:underline">← Назад към картата</a>
            <h1 class="text-3xl font-bold text-red-600 mt-2">🏃‍♂️ Бегач панел</h1>
            <p class="text-gray-600">Автоматично споделяне на локация</p>
        </div>
        
        <div class="bg-white rounded-lg shadow-lg p-6">
            <!-- Настройки -->
            <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                <h3 class="font-bold mb-3">⚙️ Настройки</h3>
                <div class="flex flex-col gap-3">
                    <div>
                        <label class="block text-sm font-bold mb-1">Интервал на изпращане:</label>
                        <select id="intervalSelect" class="border rounded px-3 py-2 w-full">
                            <option value="10">10 секунди</option>
                            <option value="30">30 секунди</option>
                            <option value="60" selected>1 минута</option>
                            <option value="120">2 минути</option>
                            <option value="300">5 минути</option>
                            <option value="600">10 минути</option>
                        </select>
                    </div>
                    <div>
                        <label class="flex items-center gap-2">
                            <input type="checkbox" id="autoSendCheckbox" checked class="w-4 h-4">
                            <span class="text-sm font-bold">Автоматично изпращане</span>
                        </label>
                    </div>
                </div>
            </div>
            
            <!-- Статус -->
            <div id="status" class="mb-4 p-3 rounded-lg bg-blue-100 text-blue-700 text-center">
                ⏳ Инициализиране...
            </div>
            
            <!-- Информация -->
            <div class="text-sm text-gray-600 space-y-1">
                <p><strong>📍 Текуща локация:</strong> <span id="currentLat">-</span>, <span id="currentLng">-</span></p>
                <p><strong>📏 Изминати км:</strong> <span id="currentDistance">0</span> / 133 км</p>
                <p><strong>🕐 Последно изпращане:</strong> <span id="lastSend">-</span></p>
                <p><strong>⏱️ Следващо изпращане:</strong> <span id="nextSend">-</span></p>
            </div>
            
            <!-- Бутони за ръчно управление -->
            <div class="mt-6 flex gap-3">
                <button onclick="sendLocationNow()" class="flex-1 bg-green-600 hover:bg-green-700 text-white font-bold py-2 rounded-lg transition">
                    📍 Изпрати сега
                </button>
                <button onclick="getLocationOnce()" class="flex-1 bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 rounded-lg transition">
                    🔍 Вземи локация
                </button>
                <button onclick="toggleAutoSend()" id="toggleBtn" class="flex-1 bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 rounded-lg transition">
                    ⏸️ Пауза
                </button>
            </div>
        </div>
        
        <div class="mt-4 text-xs text-gray-400 text-center">
            <p>📍 Локацията се изпраща автоматично на избрания интервал</p>
        </div>
    </div>
    
    <script>
        let watchId = null;
        let autoSend = true;
        let intervalSeconds = 60;
        let lastPosition = null;
        let timer = null;
        let countdown = 0;
        
        const statusDiv = document.getElementById('status');
        const currentLatSpan = document.getElementById('currentLat');
        const currentLngSpan = document.getElementById('currentLng');
        const currentDistanceSpan = document.getElementById('currentDistance');
        const lastSendSpan = document.getElementById('lastSend');
        const nextSendSpan = document.getElementById('nextSend');
        const intervalSelect = document.getElementById('intervalSelect');
        const autoSendCheckbox = document.getElementById('autoSendCheckbox');
        const toggleBtn = document.getElementById('toggleBtn');
        
        // Функция за показване на статус
        function setStatus(message, type = 'info') {
            statusDiv.innerHTML = message;
            statusDiv.className = 'mb-4 p-3 rounded-lg text-center ';
            if (type === 'success') statusDiv.classList.add('bg-green-100', 'text-green-700');
            else if (type === 'error') statusDiv.classList.add('bg-red-100', 'text-red-700');
            else statusDiv.classList.add('bg-blue-100', 'text-blue-700');
        }
        
        // Функция за изпращане на локацията
        async function sendLocation(lat, lng, distance) {
            try {
                const response = await fetch('/update-runner-location', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ lat: lat, lng: lng, distance: distance })
                });
                
                const data = await response.json();
                if (data.success) {
                    lastSendSpan.innerHTML = new Date().toLocaleTimeString();
                    setStatus(`✅ Локацията е изпратена! (${lat.toFixed(6)}, ${lng.toFixed(6)})`, 'success');
                    setTimeout(() => {
                        if (autoSend) setStatus(`⏳ Следващо изпращане след ${countdown} сек...`, 'info');
                    }, 2000);
                    return true;
                }
            } catch (error) {
                console.error('Грешка:', error);
                setStatus('❌ Грешка при изпращане', 'error');
                return false;
            }
        }
        
        // Функция за вземане и изпращане на локация
        async function getAndSendLocation() {
            if (!navigator.geolocation) {
                setStatus('❌ Браузърът не поддържа геолокация', 'error');
                return;
            }
            
            navigator.geolocation.getCurrentPosition(
                async (position) => {
                    const lat = position.coords.latitude;
                    const lng = position.coords.longitude;
                    const distance = parseFloat(document.getElementById('currentDistance').value) || 0;
                    
                    currentLatSpan.innerHTML = lat.toFixed(6);
                    currentLngSpan.innerHTML = lng.toFixed(6);
                    lastPosition = { lat, lng };
                    
                    await sendLocation(lat, lng, distance);
                },
                (error) => {
                    let msg = '';
                    switch(error.code) {
                        case error.PERMISSION_DENIED: msg = 'Няма разрешение за локация'; break;
                        case error.POSITION_UNAVAILABLE: msg = 'Локацията не е достъпна'; break;
                        case error.TIMEOUT: msg = 'Изчакването изтече'; break;
                        default: msg = error.message;
                    }
                    setStatus(`❌ Грешка: ${msg}`, 'error');
                },
                { enableHighAccuracy: true, timeout: 10000 }
            );
        }
        
        // Функция за ръчно изпращане
        async function sendLocationNow() {
            if (lastPosition) {
                const distance = parseFloat(document.getElementById('currentDistance').value) || 0;
                await sendLocation(lastPosition.lat, lastPosition.lng, distance);
                resetTimer();
            } else {
                await getAndSendLocation();
                resetTimer();
            }
        }
        
        // Функция само за вземане на локация (без изпращане)
        function getLocationOnce() {
            if (!navigator.geolocation) {
                setStatus('❌ Браузърът не поддържа геолокация', 'error');
                return;
            }
            
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    const lat = position.coords.latitude;
                    const lng = position.coords.longitude;
                    currentLatSpan.innerHTML = lat.toFixed(6);
                    currentLngSpan.innerHTML = lng.toFixed(6);
                    lastPosition = { lat, lng };
                    setStatus(`📍 Локацията е взета: ${lat.toFixed(6)}, ${lng.toFixed(6)}`, 'success');
                },
                (error) => setStatus('❌ Грешка при вземане на локация', 'error')
            );
        }
        
        // Стартиране на автоматично изпращане
        function startAutoSend() {
            if (timer) clearInterval(timer);
            
            timer = setInterval(async () => {
                if (autoSend && lastPosition) {
                    const distance = parseFloat(document.getElementById('currentDistance').value) || 0;
                    await sendLocation(lastPosition.lat, lastPosition.lng, distance);
                    resetCountdown();
                } else if (autoSend && !lastPosition) {
                    await getAndSendLocation();
                    resetCountdown();
                }
            }, intervalSeconds * 1000);
            
            resetCountdown();
        }
        
        function resetCountdown() {
            countdown = intervalSeconds;
            const countdownInterval = setInterval(() => {
                if (!autoSend) {
                    clearInterval(countdownInterval);
                    nextSendSpan.innerHTML = 'Пауза';
                    return;
                }
                if (countdown <= 0) {
                    clearInterval(countdownInterval);
                } else {
                    countdown--;
                    nextSendSpan.innerHTML = `${countdown} сек`;
                }
            }, 1000);
        }
        
        function resetTimer() {
            if (timer) {
                clearInterval(timer);
                startAutoSend();
            }
        }
        
        function toggleAutoSend() {
            autoSend = !autoSend;
            autoSendCheckbox.checked = autoSend;
            
            if (autoSend) {
                toggleBtn.innerHTML = '⏸️ Пауза';
                toggleBtn.classList.remove('bg-green-500', 'hover:bg-green-600');
                toggleBtn.classList.add('bg-yellow-500', 'hover:bg-yellow-600');
                setStatus('▶️ Автоматичното изпращане е възобновено', 'success');
                startAutoSend();
            } else {
                toggleBtn.innerHTML = '▶️ Старт';
                toggleBtn.classList.remove('bg-yellow-500', 'hover:bg-yellow-600');
                toggleBtn.classList.add('bg-green-500', 'hover:bg-green-600');
                setStatus('⏸️ Автоматичното изпращане е на пауза', 'info');
                nextSendSpan.innerHTML = 'Пауза';
            }
        }
        
        // Настройка на интервала
        intervalSelect.addEventListener('change', (e) => {
            intervalSeconds = parseInt(e.target.value);
            if (autoSend) {
                startAutoSend();
            }
            setStatus(`⏱️ Интервалът е променен на ${intervalSeconds} секунди`, 'info');
        });
        
        autoSendCheckbox.addEventListener('change', (e) => {
            autoSend = e.target.checked;
            if (autoSend) {
                startAutoSend();
                setStatus('✅ Автоматичното изпращане е активирано', 'success');
            } else {
                if (timer) clearInterval(timer);
                setStatus('⏸️ Автоматичното изпращане е деактивирано', 'info');
            }
        });
        
        // Инициализация
        function init() {
            // Започваме да следим локацията постоянно
            if (navigator.geolocation) {
                watchId = navigator.geolocation.watchPosition(
                    (position) => {
                        const lat = position.coords.latitude;
                        const lng = position.coords.longitude;
                        currentLatSpan.innerHTML = lat.toFixed(6);
                        currentLngSpan.innerHTML = lng.toFixed(6);
                        lastPosition = { lat, lng };
                        
                        if (!autoSend) {
                            setStatus('📍 Локацията се следи, но не се изпраща (пауза)', 'info');
                        }
                    },
                    (error) => console.error('Watch error:', error),
                    { enableHighAccuracy: true, maximumAge: 5000 }
                );
                
                startAutoSend();
                setStatus('✅ Системата е готова! Локацията се следи.', 'success');
            } else {
                setStatus('❌ Браузърът не поддържа геолокация', 'error');
            }
        }
        
        // Зареждане на текущото разстояние от базата
        async function loadCurrentDistance() {
            try {
                const response = await fetch('/current-runner-position');
                const data = await response.json();
                if (data && data.distance !== undefined) {
                    document.getElementById('currentDistance').value = data.distance;
                    currentDistanceSpan.innerHTML = data.distance;
                }
            } catch (error) {
                console.error('Грешка при зареждане на дистанцията:', error);
            }
        }
        
        // Обновяване на разстоянието при промяна
        document.getElementById('currentDistance').addEventListener('change', (e) => {
            currentDistanceSpan.innerHTML = e.target.value;
        });
        
        loadCurrentDistance();
        init();
        
        // Почистване при затваряне
        window.addEventListener('beforeunload', () => {
            if (watchId) navigator.geolocation.clearWatch(watchId);
            if (timer) clearInterval(timer);
        });
    </script>
</body>
</html>