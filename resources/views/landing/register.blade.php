<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Oferta Especial - Universal Gold</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-[#1e5128] to-[#1a4520] min-h-screen flex items-center justify-center py-12 px-4">
    <div class="max-w-md w-full bg-white rounded-lg shadow-xl p-8">
        <div class="text-center mb-6">
            <h1 class="text-3xl font-bold text-[#1e5128] mb-2">Universal Gold</h1>
            <p class="text-xl font-semibold text-gray-800 mb-2">Felicidades</p>
            <p class="text-2xl font-bold text-[#bc9313] mb-2">"{{ $influencer->name }}"</p>
            <p class="text-lg text-gray-700 mb-2">Te regaló este cupón</p>
            <p class="text-lg text-[#bc9313] font-semibold">¡Obtén {{ $influencer->discount_percent ?? 10 }}% de descuento!</p>
        </div>

        <form method="POST" action="{{ route('landing.register', $referral_code) }}" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nombre Completo</label>
                <input type="text" name="name" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1e5128] focus:border-[#1e5128]">
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Correo Electrónico</label>
                <input type="email" name="email" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1e5128] focus:border-[#1e5128]">
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">WhatsApp</label>
                <input type="tel" name="phone" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1e5128] focus:border-[#1e5128]"
                    placeholder="Ej: +1234567890">
                @error('phone')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                class="w-full bg-[#1e5128] text-white py-3 rounded-lg font-semibold hover:bg-[#1a4520] transition">
                Obtener Mi Cupón
            </button>
        </form>

        <p class="text-xs text-gray-500 text-center mt-4">
            Al registrarte, recibirás un cupón único con código QR para canjear en nuestra tienda.
        </p>
    </div>
</body>
</html>


