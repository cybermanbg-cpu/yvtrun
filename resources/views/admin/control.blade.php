<!DOCTYPE html>
<html>
<head>
    <title>Админ контрол - YVTRun</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    @livewireStyles
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4 max-w-2xl">
        <h1 class="text-3xl font-bold mb-4">🎮 Админ панел</h1>
        @livewire('admin-run-control')
        
        <div class="mt-6 text-center">
            <a href="/admin" class="text-blue-600">📊 Отиди към Filament админ</a>
        </div>
    </div>
    @livewireScripts
</body>
</html>