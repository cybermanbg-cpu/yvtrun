<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>🏃‍♂️ Бегач панел - YVTRun</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @livewireStyles
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4 max-w-2xl">
        <div class="text-center mb-6">
            <a href="/" class="text-blue-600 hover:underline">← Назад към картата</a>
            <h1 class="text-3xl font-bold text-red-600 mt-2">🏃‍♂️ Бегач панел - Тест</h1>
            <p class="text-gray-600">Симулация на движение по маршрута Ямбол → Велико Търново</p>
        </div>
        
        @livewire('runner-location')
        
        <div class="mt-6 bg-blue-50 border-l-4 border-blue-400 p-4 rounded">
            <p class="text-sm text-blue-700">
                <strong>ℹ️ За тест:</strong><br>
                1. Натисни "Обнови локацията" след като въведеш координати<br>
                2. Използвай +5 км / -5 км за симулация на движение<br>
                3. Отвори <a href="/" class="underline">главната страница</a> за да видиш картата
            </p>
        </div>
    </div>
    
    @livewireScripts
</body>
</html>