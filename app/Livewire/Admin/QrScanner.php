<?php

namespace App\Livewire\Admin;

use App\Models\Coupon;
use App\Models\Sale;
use Livewire\Component;

class QrScanner extends Component
{
    public $scannedCode = '';
    public $coupon = null;
    public $showSaleForm = false;
    public $saleAmount = '';
    public $notes = '';

    public function scanCoupon()
    {
        $this->coupon = Coupon::where('code', $this->scannedCode)->first();
        
        if (!$this->coupon) {
            session()->flash('error', 'Cupón no encontrado.');
            return;
        }

        if ($this->coupon->isUsed()) {
            session()->flash('error', 'Este cupón ya ha sido usado.');
            return;
        }

        $this->showSaleForm = true;
        session()->flash('success', 'Cupón encontrado. Complete los datos de la venta.');
    }

    public function registerSale()
    {
        $this->validate([
            'saleAmount' => 'required|numeric|min:0',
            'notes' => 'nullable|string|max:500',
        ]);

        if (!$this->coupon || $this->coupon->isUsed()) {
            session()->flash('error', 'Cupón inválido o ya usado.');
            return;
        }

        $lead = $this->coupon->lead;
        $influencer = $lead->influencer;

        $amount = floatval($this->saleAmount);
        $discountPercent = $influencer->discount_percent ?? 0;
        $discountApplied = ($amount * $discountPercent) / 100;
        $commissionPercent = $influencer->commission_percent ?? 0;
        $commissionAmount = ($amount * $commissionPercent) / 100;

        // Create sale
        Sale::create([
            'coupon_id' => $this->coupon->id,
            'amount' => $amount,
            'discount_applied' => $discountApplied,
            'commission_amount' => $commissionAmount,
            'notes' => $this->notes,
        ]);

        // Mark coupon as used
        $this->coupon->update([
            'status' => 'used',
            'used_at' => now(),
        ]);

        // Mark lead as converted
        $lead->update(['status' => 'converted']);

        session()->flash('success', 'Venta registrada exitosamente. Comisión: $' . number_format($commissionAmount, 2));
        
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->scannedCode = '';
        $this->coupon = null;
        $this->showSaleForm = false;
        $this->saleAmount = '';
        $this->notes = '';
    }

    public function render()
    {
        return view('livewire.admin.qr-scanner');
    }
}



