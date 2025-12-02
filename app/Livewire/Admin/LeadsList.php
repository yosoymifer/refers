<?php

namespace App\Livewire\Admin;

use App\Models\Lead;
use Livewire\Component;
use Illuminate\Support\Facades\Storage;

class LeadsList extends Component
{
    public $leads;
    public $search = '';
    public $statusFilter = 'all';

    public function mount()
    {
        $this->loadLeads();
    }

    public function loadLeads()
    {
        $query = Lead::with('influencer', 'coupon');

        if ($this->search) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%')
                  ->orWhere('phone', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->statusFilter !== 'all') {
            $query->where('status', $this->statusFilter);
        }

        $this->leads = $query->latest()->get();
    }

    public function updatedSearch()
    {
        $this->loadLeads();
    }

    public function updatedStatusFilter()
    {
        $this->loadLeads();
    }

    public function deleteLead($id)
    {
        $lead = Lead::findOrFail($id);
        
        // Delete associated coupon, QR, and sales if exists
        if ($lead->coupon) {
            // Delete associated sale if exists
            if ($lead->coupon->sale) {
                $lead->coupon->sale->delete();
            }
            
            // Delete QR image file if exists
            if ($lead->coupon->qr_path && Storage::disk('public')->exists($lead->coupon->qr_path)) {
                Storage::disk('public')->delete($lead->coupon->qr_path);
            }
            
            $lead->coupon->delete();
        }
        
        $lead->delete();
        
        session()->flash('message', 'Lead eliminado exitosamente.');
        $this->loadLeads();
    }

    public function render()
    {
        return view('livewire.admin.leads-list');
    }
}

