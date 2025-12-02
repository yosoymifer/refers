<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'lead_id',
        'code',
        'qr_path',
        'status',
        'used_at',
    ];

    protected $casts = [
        'status' => 'string',
        'used_at' => 'datetime',
    ];

    /**
     * Get the lead that owns this coupon.
     */
    public function lead(): BelongsTo
    {
        return $this->belongsTo(Lead::class);
    }

    /**
     * Get the sale for this coupon.
     */
    public function sale(): HasOne
    {
        return $this->hasOne(Sale::class);
    }

    /**
     * Check if coupon is active.
     */
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    /**
     * Check if coupon is used.
     */
    public function isUsed(): bool
    {
        return $this->status === 'used';
    }
}



