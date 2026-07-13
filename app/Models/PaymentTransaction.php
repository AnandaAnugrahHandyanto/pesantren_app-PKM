<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaymentTransaction extends Model
{
    use HasUuids;

    protected $fillable = [
        'spp_bill_id',
        'external_id',
        'snap_token',
        'amount',
        'currency',
        'channel',
        'status',
        'paid_at',
        'expired_at',
        'metadata',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'metadata' => 'array',
        'paid_at' => 'datetime',
        'expired_at' => 'datetime',
    ];

    public function sppBill(): BelongsTo
    {
        return $this->belongsTo(SppBill::class, 'spp_bill_id');
    }
}
