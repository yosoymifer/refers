<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>¡Cupón Generado! - Universal Gold</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-[#1e5128] to-[#1a4520] min-h-screen flex items-center justify-center py-12 px-4">
    <div class="max-w-md w-full bg-white rounded-lg shadow-xl p-8 text-center">
        <div class="mb-6">
            <div class="inline-block bg-green-100 rounded-full p-3 mb-4">
                <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-[#1e5128] mb-2">¡Cupón Generado!</h1>
            <p class="text-gray-600">Tu código de cupón es:</p>
            <p class="text-3xl font-bold text-[#bc9313] mt-2 font-mono">{{ $coupon->code }}</p>
        </div>

        <div class="mb-6">
            <p class="text-sm text-gray-600 mb-3">Escanea este QR en la tienda:</p>
            <div class="flex justify-center">
                <div class="border-4 border-[#1e5128] rounded-lg p-2 bg-white inline-block">
                    <img src="{{ Storage::url($coupon->qr_path) }}" alt="QR Code" class="w-64 h-64">
                </div>
            </div>
        </div>

        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
            <p class="text-sm text-yellow-800">
                <strong>Importante:</strong> Presenta este QR en nuestra tienda física para obtener tu descuento del {{ $influencer->discount_percent ?? 10 }}%.
            </p>
        </div>

        <div class="flex flex-col sm:flex-row gap-3 justify-center">
            <a href="{{ route('landing.download-qr', $coupon->code) }}" 
                class="inline-block bg-[#bc9313] text-white px-6 py-2 rounded-lg hover:bg-[#a0800f] transition text-center">
                📥 Descargar QR
            </a>
            <a href="/" class="inline-block bg-[#1e5128] text-white px-6 py-2 rounded-lg hover:bg-[#1a4520] transition text-center">
                Volver al Inicio
            </a>
        </div>
    </div>
</body>
</html>


