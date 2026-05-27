<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Доброволец - YVTRun Бягане</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <div class="container mx-auto px-4 py-8 max-w-3xl">
        <div class="text-center mb-8">
            <a href="/" class="text-blue-600 hover:underline">← Назад към картата</a>
            <h1 class="text-4xl font-bold text-blue-600 mt-4">🤝 Стани доброволец</h1>
            <p class="text-gray-600 mt-2">Без вас няма как да се случи!</p>
        </div>
        
        <div class="bg-white rounded-lg shadow-lg p-6">
            <form action="{{ route('volunteers.store') }}" method="POST">
                @csrf
                
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Твоето име *</label>
                    <input type="text" name="name" required class="w-full border rounded-lg px-3 py-2">
                </div>
                
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Телефон *</label>
                    <input type="tel" name="phone" required placeholder="0888 123 456" class="w-full border rounded-lg px-3 py-2">
                </div>
                
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Как искаш да помогнеш? *</label>
                    <select name="role" required class="w-full border rounded-lg px-3 py-2">
                        <option value="">Избери...</option>
                        @foreach($roles as $key => $role)
                            <option value="{{ $key }}">{{ $role }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Време, в което си свободен *</label>
                    <select name="time_slot" required class="w-full border rounded-lg px-3 py-2">
                        <option value="">Избери час...</option>
                        @foreach($timeSlots as $key => $slot)
                            <option value="{{ $key }}">{{ $slot }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Контролна точка (ако има)</label>
                    <select name="checkpoint_location" class="w-full border rounded-lg px-3 py-2">
                        <option value="">По трасето (подвижен екип)</option>
                        @foreach($checkpoints as $cp)
                            <option value="{{ $cp->name }}">{{ $cp->name }} ({{ $cp->distance_km }} км)</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Допълнителна информация</label>
                    <textarea name="additional_info" rows="3" placeholder="Например: имам кола, мога да возя екипа, имам камера..." class="w-full border rounded-lg px-3 py-2"></textarea>
                </div>
                
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-lg transition">
                    📝 Изпрати заявка
                </button>
            </form>
        </div>
        
        <div class="mt-6 bg-yellow-50 border-l-4 border-yellow-400 p-4">
            <p class="text-sm text-yellow-700">
                <strong>ℹ️ Информация:</strong> След регистрация ще се свържем с вас за потвърждение 
                и детайли за деня на бягането.
            </p>
        </div>
    </div>
</body>
</html>