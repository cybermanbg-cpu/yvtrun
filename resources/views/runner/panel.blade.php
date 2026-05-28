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
        <!-- Header с бутон за изход -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <a href="/" class="text-blue-600 hover:underline">← Назад към картата</a>
                <h1 class="text-3xl font-bold text-red-600 mt-2">🏃‍♂️ Бегач панел</h1>
                <p class="text-gray-600">Автоматично споделяне на локация</p>
            </div>
            <form method="POST" action="{{ route('runner.panel.logout') }}">
                @csrf
                <button type="submit"
                    class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition text-sm">
                    🚪 Изход
                </button>
            </form>
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
                <p><strong>📍 Текуща локация:</strong> <span id="currentLat">-</span>, <span id="currentLng">-</span>
                </p>
                <p><strong>📏 Изминати км:</strong>
                    <input type="number" id="distanceInput" value="0" step="0.1" min="0" max="133"
                        class="border rounded px-2 py-1 w-24"> / 133 км
                    <button onclick="manualAdjustKm()"
                        class="bg-purple-500 hover:bg-purple-600 text-white px-3 py-1 rounded-lg transition text-sm">
                        ✏️ Коригирай
                    </button>
                </p>
                <p><strong>🕐 Последно изпращане:</strong> <span id="lastSend">-</span></p>
                <p><strong>⏱️ Следващо изпращане:</strong> <span id="nextSend">-</span></p>
            </div>

            <!-- Бутони за ръчно управление -->
            <div class="mt-6 flex gap-3">
                <button onclick="sendLocationNow()"
                    class="flex-1 bg-green-600 hover:bg-green-700 text-white font-bold py-2 rounded-lg transition">
                    📍 Изпрати сега
                </button>
                <button onclick="getLocationOnce()"
                    class="flex-1 bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 rounded-lg transition">
                    🔍 Вземи локация
                </button>
                <button onclick="toggleAutoSend()" id="toggleBtn"
                    class="flex-1 bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 rounded-lg transition">
                    ⏸️ Пауза
                </button>
            </div>
        </div>

        <div class="mt-4 text-xs text-gray-400 text-center">
            <p>📍 Локацията се изпраща автоматично на избрания интервал</p>
        </div>
    </div>

    <script>
        // ============================================================
        // ОФИЦИАЛЕН МАРШРУТ С КИЛОМЕТРАЖ
        // ============================================================
        const routePoints = [{
                lat: 42.4833,
                lng: 26.5000,
                km: 0
            }, // Ямбол (старт)
            {
                lat: 42.4833,
                lng: 26.0167,
                km: 30
            }, // Нова Загора
            {
                lat: 42.7000,
                lng: 25.9000,
                km: 55
            }, // Твърдица
            {
                lat: 42.9333,
                lng: 25.8833,
                km: 90
            }, // Елена
            {
                lat: 43.0333,
                lng: 25.6167,
                km: 120
            }, // Дебелец
            {
                lat: 43.0758,
                lng: 25.6178,
                km: 133
            } // Велико Търново (финал)
        ];

        // Функция за изчисляване на разстояние между две точки (в км) - Haversine формула
        function calculateDistance(lat1, lng1, lat2, lng2) {
            const R = 6371; // Радиус на Земята в км
            const dLat = (lat2 - lat1) * Math.PI / 180;
            const dLng = (lng2 - lng1) * Math.PI / 180;
            const a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
                Math.sin(dLng / 2) * Math.sin(dLng / 2);
            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
            return R * c;
        }

        // Функция за намиране на проекционния фактор
        function getProjectionFactor(lat, lng, lat1, lng1, lat2, lng2) {
            const dx = (lng2 - lng1) * Math.cos(lat1 * Math.PI / 180) * 111320;
            const dy = (lat2 - lat1) * 110574;
            const px = (lng - lng1) * Math.cos(lat1 * Math.PI / 180) * 111320;
            const py = (lat - lat1) * 110574;

            const dot = (px * dx + py * dy);
            const len2 = (dx * dx + dy * dy);

            if (len2 === 0) return 0;
            return Math.max(0, Math.min(1, dot / len2));
        }

        // Функция за намиране на най-близката точка от маршрута
        function findNearestPointOnRoute(lat, lng) {
            let minDistance = Infinity;
            let closestKm = 0;

            for (let i = 0; i < routePoints.length - 1; i++) {
                const p1 = routePoints[i];
                const p2 = routePoints[i + 1];

                const segmentLength = calculateDistance(p1.lat, p1.lng, p2.lat, p2.lng);
                const t = getProjectionFactor(lat, lng, p1.lat, p1.lng, p2.lat, p2.lng);

                let projectedKm;
                if (t <= 0) {
                    projectedKm = p1.km;
                } else if (t >= 1) {
                    projectedKm = p2.km;
                } else {
                    projectedKm = p1.km + t * (p2.km - p1.km);
                }

                // Изчисляване на разстоянието до сегмента
                const projLat = p1.lat + t * (p2.lat - p1.lat);
                const projLng = p1.lng + t * (p2.lng - p1.lng);
                const distanceToSegment = calculateDistance(lat, lng, projLat, projLng);

                if (distanceToSegment < minDistance) {
                    minDistance = distanceToSegment;
                    closestKm = projectedKm;
                }
            }

            return Math.min(Math.max(closestKm, 0), 133);
        }

        // ============================================================
        // ОСНОВНА ЛОГИКА
        // ============================================================
        let watchId = null;
        let autoSend = true;
        let intervalSeconds = 60;
        let lastPosition = null;
        let timer = null;
        let countdown = 0;
        let currentKm = 0;

        const statusDiv = document.getElementById('status');
        const currentLatSpan = document.getElementById('currentLat');
        const currentLngSpan = document.getElementById('currentLng');
        const distanceInput = document.getElementById('distanceInput');
        const lastSendSpan = document.getElementById('lastSend');
        const nextSendSpan = document.getElementById('nextSend');
        const intervalSelect = document.getElementById('intervalSelect');
        const autoSendCheckbox = document.getElementById('autoSendCheckbox');
        const toggleBtn = document.getElementById('toggleBtn');

        function setStatus(message, type = 'info') {
            statusDiv.innerHTML = message;
            statusDiv.className = 'mb-4 p-3 rounded-lg text-center ';
            if (type === 'success') statusDiv.classList.add('bg-green-100', 'text-green-700');
            else if (type === 'error') statusDiv.classList.add('bg-red-100', 'text-red-700');
            else statusDiv.classList.add('bg-blue-100', 'text-blue-700');
        }

        async function sendLocation(lat, lng, distance, speed = null, accuracy = null, battery = null) {
            try {
                const payload = {
                    lat: lat,
                    lng: lng,
                    distance: distance
                };

                if (speed !== null) payload.speed = parseFloat(speed);
                if (accuracy !== null) payload.accuracy = accuracy;
                if (battery !== null) payload.battery = battery;

                const response = await fetch('/update-runner-location', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify(payload)
                });

                const data = await response.json();
                if (data.success) {
                    lastSendSpan.innerHTML = new Date().toLocaleTimeString();

                    let logMsg = `✅ Изпратено! (${lat.toFixed(6)}, ${lng.toFixed(6)}) - ${distance.toFixed(1)} км`;
                    if (speed) logMsg += ` | ⚡ ${speed} км/ч`;
                    if (accuracy) logMsg += ` | 🎯 ±${accuracy}м`;
                    if (battery) logMsg += ` | 🔋 ${battery}%`;

                    setStatus(logMsg, 'success');
                    return true;
                }
            } catch (error) {
                console.error('Грешка:', error);
                setStatus('❌ Грешка при изпращане към сървъра', 'error');
                return false;
            }
        }

        // Автоматично вземане и изпращане на локация с изчислени километри
        async function getAndSendLocation() {
            if (!navigator.geolocation) {
                setStatus('❌ Браузърът не поддържа геолокация', 'error');
                return;
            }

            setStatus('⏳ Вземане на локация...', 'info');

            async function getAndSendLocation() {
                if (!navigator.geolocation) {
                    setStatus('❌ Браузърът не поддържа геолокация', 'error');
                    return;
                }

                setStatus('⏳ Вземане на локация...', 'info');

                // Проверка за батерия (ако е поддържана)
                let batteryLevel = null;
                if (navigator.getBattery) {
                    try {
                        const battery = await navigator.getBattery();
                        batteryLevel = Math.round(battery.level * 100);
                    } catch (err) {
                        console.log('Не може да се вземе батерията:', err);
                    }
                }

                navigator.geolocation.getCurrentPosition(
                    async (position) => {
                            const lat = position.coords.latitude;
                            const lng = position.coords.longitude;
                            const speed = position.coords.speed ? (position.coords.speed * 3.6).toFixed(1) :
                                null; // m/s to km/h
                            const accuracy = Math.round(position.coords.accuracy); // точност в метри
                            const altitude = position.coords.altitude ? position.coords.altitude.toFixed(0) :
                                null;

                            // АВТОМАТИЧНО ИЗЧИСЛЯВАНЕ на километрите от маршрута
                            const calculatedKm = findNearestPointOnRoute(lat, lng);
                            currentKm = calculatedKm;

                            // Обнови полетата
                            distanceInput.value = currentKm.toFixed(1);
                            currentLatSpan.innerHTML = lat.toFixed(6);
                            currentLngSpan.innerHTML = lng.toFixed(6);
                            lastPosition = {
                                lat,
                                lng
                            };

                            // Подробен статус
                            let statusMsg =
                                `📍 ${lat.toFixed(6)}, ${lng.toFixed(6)} | 📏 ${currentKm.toFixed(1)} км`;
                            if (speed) statusMsg += ` | ⚡ ${speed} км/ч`;
                            if (accuracy) statusMsg += ` | 🎯 ±${accuracy}м`;
                            if (batteryLevel !== null) statusMsg += ` | 🔋 ${batteryLevel}%`;
                            if (altitude) statusMsg += ` | 🏔️ ${altitude}м`;

                            setStatus(statusMsg, 'success');

                            // Автоматично изпращане (ако е включено)
                            if (autoSend) {
                                await sendLocation(lat, lng, currentKm, speed, accuracy, batteryLevel);
                            }
                        },
                        (error) => {
                            let msg = '';
                            switch (error.code) {
                                case error.PERMISSION_DENIED:
                                    msg =
                                        'Няма разрешение за локация. Моля, разреши достъп от настройките на телефона.';
                                    break;
                                case error.POSITION_UNAVAILABLE:
                                    msg = 'Локацията не е достъпна. Провери дали GPS е включен.';
                                    break;
                                case error.TIMEOUT:
                                    msg = 'Изчакването изтече. Опитай отново.';
                                    break;
                                default:
                                    msg = error.message;
                            }
                            setStatus(`❌ Грешка: ${msg}`, 'error');
                        }, {
                            enableHighAccuracy: true, // Включва GPS за максимална точност
                            timeout: 10000, // 10 секунди максимум
                            maximumAge: 0 // Не използва кеширана локация
                        }
                );
            }
        }

        // Изпращане на текущата локация (с ръчно въведени км)
        async function sendLocationNow() {
            if (lastPosition) {
                const distance = parseFloat(distanceInput.value) || currentKm;
                currentKm = distance;
                await sendLocation(lastPosition.lat, lastPosition.lng, distance);
                resetTimer();
            } else {
                await getAndSendLocation();
                resetTimer();
            }
        }

        // Само вземане на локация (без изпращане)
        function getLocationOnce() {
            if (!navigator.geolocation) {
                setStatus('❌ Браузърът не поддържа геолокация', 'error');
                return;
            }

            navigator.geolocation.getCurrentPosition(
                (position) => {
                    const lat = position.coords.latitude;
                    const lng = position.coords.longitude;
                    const calculatedKm = findNearestPointOnRoute(lat, lng);

                    currentLatSpan.innerHTML = lat.toFixed(6);
                    currentLngSpan.innerHTML = lng.toFixed(6);
                    distanceInput.value = calculatedKm.toFixed(1);
                    lastPosition = {
                        lat,
                        lng
                    };
                    currentKm = calculatedKm;

                    setStatus(`📍 Локация: ${lat.toFixed(6)}, ${lng.toFixed(6)} | 📏 ${calculatedKm.toFixed(1)} км`,
                        'success');
                },
                (error) => setStatus('❌ Грешка при вземане на локация', 'error')
            );
        }

        // Ръчна корекция на километрите
        function manualAdjustKm() {
            const newKm = parseFloat(distanceInput.value);
            if (!isNaN(newKm) && newKm >= 0 && newKm <= 133) {
                currentKm = newKm;
                setStatus(`✏️ Километрите са коригирани на ${currentKm.toFixed(1)} км`, 'success');

                if (lastPosition && autoSend) {
                    sendLocation(lastPosition.lat, lastPosition.lng, currentKm);
                }
            } else {
                setStatus('❌ Моля въведете стойност между 0 и 133', 'error');
                distanceInput.value = currentKm.toFixed(1);
            }
        }

        function startAutoSend() {
            if (timer) clearInterval(timer);
            timer = setInterval(async () => {
                if (autoSend && lastPosition) {
                    const distance = parseFloat(distanceInput.value) || currentKm;
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
                toggleBtn.classList.remove('bg-green-500');
                toggleBtn.classList.add('bg-yellow-500');
                setStatus('▶️ Автоматичното изпращане е възобновено', 'success');
                startAutoSend();
            } else {
                toggleBtn.innerHTML = '▶️ Старт';
                toggleBtn.classList.remove('bg-yellow-500');
                toggleBtn.classList.add('bg-green-500');
                setStatus('⏸️ Автоматичното изпращане е на пауза', 'info');
                nextSendSpan.innerHTML = 'Пауза';
            }
        }

        intervalSelect.addEventListener('change', (e) => {
            intervalSeconds = parseInt(e.target.value);
            if (autoSend) startAutoSend();
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

        function init() {
            if (navigator.geolocation) {
                watchId = navigator.geolocation.watchPosition(
                    (position) => {
                        const lat = position.coords.latitude;
                        const lng = position.coords.longitude;
                        const speed = position.coords.speed ? (position.coords.speed * 3.6).toFixed(1) : null;
                        const accuracy = Math.round(position.coords.accuracy);
                        const calculatedKm = findNearestPointOnRoute(lat, lng);

                        currentLatSpan.innerHTML = lat.toFixed(6);
                        currentLngSpan.innerHTML = lng.toFixed(6);
                        distanceInput.value = calculatedKm.toFixed(1);
                        lastPosition = {
                            lat,
                            lng
                        };
                        currentKm = calculatedKm;

                        // Опционално: покажи в статуса, но без спам
                        // setStatus(`📍 Следене: ${lat.toFixed(6)}, ${lng.toFixed(6)} | 📏 ${calculatedKm.toFixed(1)} км`, 'info');
                    },
                    (error) => console.error('Watch error:', error), {
                        enableHighAccuracy: true,
                        maximumAge: 5000, // 5 секунди кеш
                        timeout: 10000
                    }
                );
                startAutoSend();
                setStatus('✅ Системата е готова! Локацията се следи.', 'success');
            } else {
                setStatus('❌ Браузърът не поддържа геолокация', 'error');
            }
        }

        async function loadCurrentDistance() {
            try {
                const response = await fetch('/current-runner-position');
                const data = await response.json();
                if (data && data.distance !== undefined) {
                    distanceInput.value = data.distance;
                    currentKm = data.distance;
                }
            } catch (error) {
                console.error('Грешка при зареждане на дистанцията:', error);
            }
        }

        distanceInput.addEventListener('change', (e) => {
            currentKm = parseFloat(e.target.value) || 0;
        });

        loadCurrentDistance();
        init();

        window.addEventListener('beforeunload', () => {
            if (watchId) navigator.geolocation.clearWatch(watchId);
            if (timer) clearInterval(timer);
        });
    </script>
</body>

</html>
