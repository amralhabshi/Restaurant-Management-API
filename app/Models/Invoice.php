<?php

namespace App\Models;

use App\Models\Order;
use App\Models\Payment;
use App\Models\Refund;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Invoice Model
 *
 * @property int $id
 * @property int $order_id
 * @property string $invoice_number
 * @property float $subtotal
 * @property float $tax
 * @property float $discount
 * @property float $total
 * @property Carbon|null $issued_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property float $refunded_total
 *
 * @property-read Order $order
 * @property-read Collection<int, Payment> $payments
 * @property-read Collection<int, Refund> $refunds
 * 
 */
class Invoice extends Model
{
    protected $fillable = [
        'order_id',
        'invoice_number',
        'subtotal',
        'tax',
        'discount',
        'total',
        'issued_at',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'tax' => 'decimal:2',
        'discount' => 'decimal:2',
        'total' => 'decimal:2',
        'refunded_total' => 'decimal:2',
        'issued_at' => 'datetime',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    /**
    * المسترجعات الخاصة بالفاتورة
    */
    public function refunds(): HasMany
    {
        return $this->hasMany(Refund::class);
    }
}