<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Благодарим ви! - YVTRun</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <div class="container mx-auto px-4 py-16 max-w-2xl text-center">
        <div class="bg-white rounded-lg shadow-lg p-8">
            <div class="text-6xl mb-4">❤️</div>
            <h1 class="text-3xl font-bold text-green-600 mb-4">Благодарим ви!</h1>
            <p class="text-gray-700 mb-6">
                Вашето дарение от <strong>{{ number_format($donation->amount, 2) }} лв.</strong> е получено.
                Вие сте част от каузата!
            </p>
            <div class="bg-gray-100 p-4 rounded mb-6">
                <p class="text-gray-600">Благодарим на:</p>
                <p class="font-bold">{{ $donation->donor_name }}</p>
                @if($donation->message)
                    <p class="text-gray-500 italic mt-2">"{{ $donation->message }}"</p>
                @endif
            </div>
            <a href="/" class="inline-block bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                ← Към картата на бягането
            </a>
        </div>
    </div>
</body>
</html>