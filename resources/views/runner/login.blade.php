<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Вход - Бегач панел | YVTRun</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-16 max-w-md">
        <div class="text-center mb-8">
            <h1 class="text-5xl font-bold text-red-600 mb-2">🏃‍♂️ YVTRun</h1>
            <p class="text-gray-600">Панел на бегача</p>
        </div>
        
        <div class="bg-white rounded-lg shadow-lg p-8">
            <h2 class="text-2xl font-bold mb-6 text-center">🔐 Защитен достъп</h2>
            
            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ $errors->first('password') }}
                </div>
            @endif
            
            <form method="POST" action="{{ route('runner.panel') }}">
                @csrf
                <div class="mb-6">
                    <label class="block text-gray-700 font-bold mb-2">Парола за достъп</label>
                    <input type="password" name="password" 
                           class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:border-red-500"
                           placeholder="Въведете парола" autofocus>
                </div>
                <button type="submit" 
                        class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-2 rounded-lg transition">
                    📍 Вход в панела
                </button>
            </form>
            
            <div class="mt-4 text-center text-sm text-gray-500">
                <a href="/" class="text-blue-600 hover:underline">← Назад към картата</a>
            </div>
        </div>
    </div>
</body>
</html>