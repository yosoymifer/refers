<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'coupon_id',
        'amount',
        'discount_applied',
        'commission_amount',
        'notes',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'discount_applied' => 'decimal:2',
        'commission_amount' => 'decimal:2',
    ];

    /**
     * Get the coupon for this sale.
     */
    public function coupon(): BelongsTo
    {
        return $this->belongsTo(Coupon::class);
    }

    /**
     * Get the lead through coupon.
     */
    public function lead()
    {
        return $this->coupon->lead ?? null;
    }

    /**
     * Get the influencer through coupon and lead.
     */
    public function influencer()
    {
        return $this->lead()?->influencer ?? null;
    }
}


