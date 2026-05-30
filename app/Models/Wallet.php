<?php

namespace App\Models;

use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Wallet Model
 *
 * أعمدة الجدول
 *
 * @property int $id
 * @property int $customer_id
 * @property float $balance
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * العلاقات
 *
 * @property-read Customer $customer
 */
class Wallet extends Model
{
    protected $fillable = [
        'customer_id',
        'balance',
    ];

    protected $casts = [
        'balance' => 'decimal:2',
    ];

    /**
     * المحفظة تتبع عميل
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
}