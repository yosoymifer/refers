<?php

namespace App\Livewire\Admin;

use App\Models\Lead;
use App\Models\Sale;
use App\Models\User;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        $stats = [
            'total_influencers' => User::where('role', 'influencer')->count(),
            'active_influencers' => User::where('role', 'influencer')->where('is_active', true)->count(),
            'total_leads' => Lead::count(),
            'pending_leads' => Lead::where('status', 'pending')->count(),
            'converted_leads' => Lead::where('status', 'converted')->count(),
            'total_sales' => Sale::count(),
            'total_revenue' => Sale::sum('amount'),
            'total_commissions' => Sale::sum('commission_amount'),
        ];

        $recent_leads = Lead::with('influencer')->latest()->take(5)->get();
        $recent_sales = Sale::with(['coupon.lead.influencer'])->latest()->take(5)->get();

        return view('livewire.admin.dashboard', [
            'stats' => $stats,
            'recent_leads' => $recent_leads,
            'recent_sales' => $recent_sales,
        ]);
    }
}



