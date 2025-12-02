<div>
    <!-- Referral Code Section -->
    <div class="bg-white rounded-lg shadow p-6 mb-8">
        <h2 class="text-xl font-bold text-[#1e5128] mb-4">Mi Código de Referido</h2>
        <div class="flex items-center space-x-4">
            <div class="flex-1">
                <p class="text-sm text-gray-600 mb-2">Comparte este enlace o código:</p>
                <div class="flex items-center space-x-2">
                    <input type="text" value="{{ $referral_url }}" readonly class="flex-1 px-4 py-2 border border-gray-300 rounded-lg bg-gray-50">
                    <button onclick="navigator.clipboard.writeText('{{ $referral_url }}')" class="bg-[#1e5128] text-white px-4 py-2 rounded-lg hover:bg-[#1a4520] transition">
                        Copiar
                    </button>
                </div>
                <p class="text-xs text-gray-500 mt-2">Código: <span class="font-mono font-bold">{{ auth()->user()->referral_code }}</span></p>
            </div>
            <div class="text-center">
                <p class="text-sm text-gray-600 mb-2">Tu QR</p>
                <div class="bg-gray-100 p-4 rounded-lg inline-block">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ urlencode($referral_url) }}" alt="QR Code">
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <p class="text-sm font-medium text-gray-600">Total Leads</p>
            <p class="text-2xl font-bold text-[#1e5128]">{{ $stats['total_leads'] }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <p class="text-sm font-medium text-gray-600">Pendientes</p>
            <p class="text-2xl font-bold text-yellow-600">{{ $stats['pending_leads'] }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <p class="text-sm font-medium text-gray-600">Convertidos</p>
            <p class="text-2xl font-bold text-green-600">{{ $stats['converted_leads'] }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <p class="text-sm font-medium text-gray-600">Mis Comisiones</p>
            <p class="text-2xl font-bold text-[#bc9313]">${{ number_format($stats['total_commissions'], 2) }}</p>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-[#1e5128]">Mis Leads Recientes</h3>
            </div>
            <div class="p-6">
                @if($recent_leads->count() > 0)
                    <div class="space-y-4">
                        @foreach($recent_leads as $lead)
                            <div class="flex items-center justify-between border-b border-gray-100 pb-3 last:border-0 last:pb-0">
                                <div>
                                    <p class="font-medium text-gray-900">{{ $lead->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $lead->email }}</p>
                                </div>
                                <span class="px-2 py-1 text-xs rounded-full {{ $lead->status === 'converted' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ $lead->status === 'converted' ? 'Convertido' : 'Pendiente' }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-4">No tienes leads aún</p>
                @endif
            </div>
        </div>

        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-[#1e5128]">Mis Ventas</h3>
            </div>
            <div class="p-6">
                @if($recent_sales->count() > 0)
                    <div class="space-y-4">
                        @foreach($recent_sales as $sale)
                            <div class="flex items-center justify-between border-b border-gray-100 pb-3 last:border-0 last:pb-0">
                                <div>
                                    <p class="font-medium text-gray-900">${{ number_format($sale->amount, 2) }}</p>
                                    <p class="text-sm text-gray-500">{{ $sale->coupon->lead->name ?? 'N/A' }}</p>
                                </div>
                                <span class="text-sm font-semibold text-[#bc9313]">
                                    +${{ number_format($sale->commission_amount, 2) }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-4">No tienes ventas aún</p>
                @endif
            </div>
        </div>
    </div>
</div>

