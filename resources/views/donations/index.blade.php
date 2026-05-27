<!DOCTYPE html>
<html lang="bg">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Дари - YVTRun Благотворително бягане</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50">
    <div class="container mx-auto px-4 py-8 max-w-4xl">
        <!-- Header -->
        <div class="text-center mb-8">
            <a href="/" class="text-blue-600 hover:underline">← Назад към картата</a>
            <h1 class="text-4xl font-bold text-green-600 mt-4">❤️ Подкрепи каузата</h1>
            <p class="text-gray-600 mt-2">Всяко дарение отива за благотворителност</p>
        </div>

        <!-- Stats -->
        <div class="grid md:grid-cols-3 gap-4 mb-8">
            <div class="bg-white rounded-lg shadow p-4 text-center">
                <div class="text-3xl font-bold text-green-600">{{ number_format($totalRaised, 0) }} лв.</div>
                <div class="text-gray-600">Събрани средства</div>
            </div>
            <div class="bg-white rounded-lg shadow p-4 text-center">
                <div class="text-3xl font-bold text-blue-600">{{ $donorsCount }}</div>
                <div class="text-gray-600">Дарители</div>
            </div>
            <div class="bg-white rounded-lg shadow p-4 text-center">
                <div class="text-3xl font-bold text-purple-600">133 км</div>
                <div class="text-gray-600">Бягаме заедно</div>
            </div>
        </div>

        <!-- Top Donors -->
        @if ($topDonors->count() > 0)
            <div class="bg-white rounded-lg shadow p-4 mb-6">
                <h2 class="text-xl font-bold mb-3">🏆 Топ дарители</h2>
                <div class="space-y-2">
                    @foreach ($topDonors as $donor)
                        <div class="flex justify-between items-center border-b pb-2">
                            <span class="font-medium">{{ $donor->donor_name }}</span>
                            <span class="text-green-600 font-bold">{{ number_format($donor->amount, 0) }} лв.</span>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Donation Form -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-2xl font-bold mb-4">📝 Формуляр за дарение</h2>

            <form action="{{ route('donations.store') }}" method="POST">
                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        {{ session('error') }}
                    </div>
                @endif
                @csrf

                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Сума (лв.) *</label>
                    <div class="flex gap-2 mb-2">
                        <button type="button" onclick="document.getElementById('amount').value=10"
                            class="bg-gray-200 px-4 py-2 rounded hover:bg-gray-300">10 лв.</button>
                        <button type="button" onclick="document.getElementById('amount').value=20"
                            class="bg-gray-200 px-4 py-2 rounded hover:bg-gray-300">20 лв.</button>
                        <button type="button" onclick="document.getElementById('amount').value=50"
                            class="bg-gray-200 px-4 py-2 rounded hover:bg-gray-300">50 лв.</button>
                        <button type="button" onclick="document.getElementById('amount').value=100"
                            class="bg-gray-200 px-4 py-2 rounded hover:bg-gray-300">100 лв.</button>
                    </div>
                    <input type="number" name="amount" id="amount" step="1" min="1" max="10000"
                        required class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:border-green-500">
                </div>

                <div class="mb-4">
                    <label class="flex items-center">
                        <input type="checkbox" name="is_anonymous" value="1" class="mr-2">
                        <span class="text-gray-700">Искам дарението да е анонимно</span>
                    </label>
                </div>

                <div id="nameField" class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Име *</label>
                    <input type="text" name="donor_name"
                        class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:border-green-500">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Имейл *</label>
                    <input type="email" name="email" required
                        class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:border-green-500">
                    <p class="text-sm text-gray-500 mt-1">Ще получите благодарствено писмо</p>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Адрес</label>
                    <textarea name="address" rows="2"
                        class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:border-green-500"></textarea>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Послание (по желание)</label>
                    <textarea name="message" rows="3" placeholder="Напишете нещо за бягащия..."
                        class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:border-green-500"></textarea>
                </div>

                <button type="submit"
                    class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 rounded-lg transition">
                    ❤️ Дари сега
                </button>
            </form>
        </div>
    </div>

    <script>
        // Скриване/показване на полето за име при анонимно дарение
        document.querySelector('input[name="is_anonymous"]').addEventListener('change', function(e) {
            const nameField = document.getElementById('nameField');
            if (e.target.checked) {
                nameField.style.display = 'none';
                document.querySelector('input[name="donor_name"]').value = '';
            } else {
                nameField.style.display = 'block';
            }
        });
    </script>
</body>

</html>
