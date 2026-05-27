<!DOCTYPE html>
<html lang="bg">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>🏃‍♂️ YVTRun - Благотворително бягане Ямбол до Велико Търново 133км</title>

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <!-- Tailwind CSS CDN (за бързо тестване) -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Livewire Styles -->
    @livewireStyles
</head>

<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8 max-w-6xl">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-5xl font-bold text-red-600 mb-2">🏃‍♂️ Ямбол → Велико Търново</h1>
            <p class="text-xl text-gray-600">133 км благотворително бягане за 24 часа</p>
            <div class="mt-2 text-amber-600">
                ⭐ Бягаме заедно, помагаме на нуждаещите се ⭐
            </div>
        </div>

        <!-- 📊 Секция за даренията (НОВА) -->
        <div class="mb-8">
            <div class="bg-gradient-to-r from-green-500 to-green-700 rounded-xl shadow-lg p-6 text-white">
                <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                    <div class="text-center md:text-left">
                        <p class="text-sm uppercase tracking-wide opacity-90">Събрани средства</p>
                        <p class="text-4xl font-bold">{{ number_format($totalRaised, 0) }} лв.</p>
                        <p class="text-sm opacity-90">от цел {{ number_format($goalAmount, 0) }} лв.</p>
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
                
                <!-- Анимиран текстов поздрав -->
                <div class="mt-4 text-center bg-white/20 rounded-lg p-2">
                    <p class="text-sm">
                        @if($percentage < 25)
                            🎯 Направете първата крачка - дарете сега!
                        @elseif($percentage < 50)
                            💪 Продължаваме напред! Вие правите разликата.
                        @elseif($percentage < 75)
                            🚀 Близо сме до целта! Благодарим на всички дарители.
                        @elseif($percentage < 100)
                            🎉 Почти успяхме! Помогнете да достигнем целта.
                        @else
                            🏆 ЦЕЛТА Е ПОСТИГНАТА! Безкрайни благодарности!
                        @endif
                    </p>
                </div>
            </div>
        </div>

        <!-- Live Map Component -->
        @livewire('live-map')

        <!-- След картата, добави тази секция -->
        <div class="mt-8 bg-white rounded-lg shadow p-4">
            <h2 class="text-2xl font-bold mb-4 flex items-center gap-2">
                <span class="text-red-600">🎥</span>
                На живо от бягането
            </h2>

            @php
                $liveVideo = App\Models\YouTubeVideo::where('is_active', true)
                    ->where('is_live', true)
                    ->orderBy('scheduled_at', 'desc')
                    ->first();
                $featuredVideo =
                    $liveVideo ??
                    App\Models\YouTubeVideo::where('is_active', true)->orderBy('scheduled_at', 'desc')->first();
            @endphp

            @if ($featuredVideo)
                <div class="aspect-video w-full">
                    <iframe class="w-full h-full rounded-lg" src="{{ $featuredVideo->embed_url }}"
                        title="{{ $featuredVideo->title }}" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen>
                    </iframe>
                </div>
                <p class="text-center mt-2 text-gray-600">{{ $featuredVideo->title }}</p>
            @else
                <div class="bg-gray-100 rounded-lg p-8 text-center">
                    <p class="text-gray-500">⏳ Скоро ще има видео от бягането...</p>
                    <p class="text-sm text-gray-400 mt-2">Очаквайте лайфстрийм на 15 юни 2025</p>
                </div>
            @endif
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
            <a href="#"
                class="bg-purple-500 hover:bg-purple-600 text-white font-bold py-3 px-6 rounded-full transition shadow-lg transform hover:scale-105">
                📸 Видео от бягането
            </a>
        </div>

        <!-- Info Section -->
        <div class="mt-12 bg-white rounded-lg shadow p-6">
            <h2 class="text-2xl font-bold mb-4">📅 Информация за събитието</h2>
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <p class="mb-2"><strong>📍 Старт:</strong> Ямбол, Централен площад</p>
                    <p class="mb-2"><strong>🏁 Финал:</strong> Велико Търново, Крепост Царевец</p>
                    <p class="mb-2"><strong>📏 Дистанция:</strong> 133 километра</p>
                    <p><strong>🎯 Цел:</strong> Събиране на средства за ...</p>
                </div>
                <div>
                    <p class="mb-2"><strong>👥 Екип:</strong> Търсим доброволци!</p>
                    <p class="mb-2"><strong>🚰 Почивки:</strong> Нова Загора, Твърдица, Елена, Дебелец</p>
                    <p><strong>📱 Хештег:</strong> #YVTRun2026</p>
                </div>
            </div>
        </div>
        
        <!-- Скрипт за автоматично опресняване на сумата (ако ползваш AJAX) -->
        <script>
            // Автоматично опресняване на сумата на даренията на всеки 30 секунди
            setInterval(function() {
                fetch('/api/donations-stats')
                    .then(response => response.json())
                    .then(data => {
                        // Тук можеш да обновиш стойностите динамично
                        console.log('Stats updated:', data);
                    })
                    .catch(error => console.error('Error:', error));
            }, 30000);
        </script>
    </div>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    @livewireScripts
</body>

</html>