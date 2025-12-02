<div>
    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Influencers</p>
                    <p class="text-2xl font-bold text-[#1e5128]">{{ $stats['total_influencers'] }}</p>
                </div>
                <div class="bg-[#1e5128] bg-opacity-10 rounded-full p-3">
                    <svg class="w-6 h-6 text-[#1e5128]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
            </div>
            <p class="text-xs text-gray-500 mt-2">{{ $stats['active_influencers'] }} activos</p>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Leads</p>
                    <p class="text-2xl font-bold text-[#1e5128]">{{ $stats['total_leads'] }}</p>
                </div>
                <div class="bg-[#bc9313] bg-opacity-10 rounded-full p-3">
                    <svg class="w-6 h-6 text-[#bc9313]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
            </div>
            <p class="text-xs text-gray-500 mt-2">{{ $stats['pending_leads'] }} pendientes</p>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Ventas</p>
                    <p class="text-2xl font-bold text-[#1e5128]">{{ $stats['total_sales'] }}</p>
                </div>
                <div class="bg-[#1e5128] bg-opacity-10 rounded-full p-3">
                    <svg class="w-6 h-6 text-[#1e5128]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <p class="text-xs text-gray-500 mt-2">${{ number_format($stats['total_revenue'], 2) }} en ventas</p>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Comisiones Pagadas</p>
                    <p class="text-2xl font-bold text-[#bc9313]">${{ number_format($stats['total_commissions'], 2) }}</p>
                </div>
                <div class="bg-[#bc9313] bg-opacity-10 rounded-full p-3">
                    <svg class="w-6 h-6 text-[#bc9313]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
            </div>
            <p class="text-xs text-gray-500 mt-2">Total acumulado</p>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Leads -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-[#1e5128]">Leads Recientes</h3>
            </div>
            <div class="p-6">
                @if($recent_leads->count() > 0)
                    <div class="space-y-4">
                        @foreach($recent_leads as $lead)
                            <div class="flex items-center justify-between border-b border-gray-100 pb-3 last:border-0 last:pb-0">
                                <div>
                                    <p class="font-medium text-gray-900">{{ $lead->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $lead->email }}</p>
                                    <p class="text-xs text-gray-400">Por: {{ $lead->influencer->name }}</p>
                                </div>
                                <span class="px-2 py-1 text-xs rounded-full {{ $lead->status === 'converted' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ $lead->status === 'converted' ? 'Convertido' : 'Pendiente' }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-4">No hay leads recientes</p>
                @endif
            </div>
        </div>

        <!-- Recent Sales -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-[#1e5128]">Ventas Recientes</h3>
            </div>
            <div class="p-6">
                @if($recent_sales->count() > 0)
                    <div class="space-y-4">
                        @foreach($recent_sales as $sale)
                            <div class="flex items-center justify-between border-b border-gray-100 pb-3 last:border-0 last:pb-0">
                                <div>
                                    <p class="font-medium text-gray-900">${{ number_format($sale->amount, 2) }}</p>
                                    <p class="text-sm text-gray-500">{{ $sale->coupon->lead->name ?? 'N/A' }}</p>
                                    <p class="text-xs text-gray-400">Influencer: {{ $sale->coupon->lead->influencer->name ?? 'N/A' }}</p>
                                </div>
                                <span class="text-sm font-semibold text-[#bc9313]">
                                    Comisión: ${{ number_format($sale->commission_amount, 2) }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-4">No hay ventas recientes</p>
                @endif
            </div>
        </div>
    </div>
</div>



