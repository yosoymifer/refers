<?php

namespace App\Livewire\Influencer;

use App\Models\Lead;
use App\Models\Sale;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        $user = auth()->user();
        
        $stats = [
            'total_leads' => Lead::where('user_id', $user->id)->count(),
            'pending_leads' => Lead::where('user_id', $user->id)->where('status', 'pending')->count(),
            'converted_leads' => Lead::where('user_id', $user->id)->where('status', 'converted')->count(),
            'total_sales' => Sale::whereHas('coupon.lead', function($q) use ($user) {
                $q->where('user_id', $user->id);
            })->count(),
            'total_commissions' => Sale::whereHas('coupon.lead', function($q) use ($user) {
                $q->where('user_id', $user->id);
            })->sum('commission_amount'),
        ];

        $recent_leads = Lead::where('user_id', $user->id)->latest()->take(5)->get();
        $recent_sales = Sale::whereHas('coupon.lead', function($q) use ($user) {
            $q->where('user_id', $user->id);
        })->with(['coupon.lead'])->latest()->take(5)->get();

        $referral_url = route('landing.register', ['code' => $user->referral_code]);

        return view('livewire.influencer.dashboard', [
            'stats' => $stats,
            'recent_leads' => $recent_leads,
            'recent_sales' => $recent_sales,
            'referral_url' => $referral_url,
        ]);
    }
}


