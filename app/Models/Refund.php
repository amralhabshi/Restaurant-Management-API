<?php

namespace App\Models;

use App\Models\Invoice;
use App\Models\Employee;
use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Refund Model
 *
 * أعمدة الجدول
 *
 * @property int $id
 * @property int $invoice_id
 * @property int $employee_id
 * @property int|null $customer_id
 * @property string $refund_number
 * @property float $amount
 * @property string $reason
 * @property string|null $notes
 * @property Carbon $refunded_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * العلاقات
 *
 * @property-read Invoice $invoice
 * @property-read Employee $employee
 * @property-read Customer|null $customer
 */
class Refund extends Model
{
    protected $fillable = [
        'invoice_id',
        'employee_id',
        'customer_id',
        'refund_number',
        'amount',
        'reason',
        'notes',
        'refunded_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'refunded_at' => 'datetime',
    ];

    /**
     * الاسترجاع مرتبط بفاتورة
     */
    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }

    /**
     * الموظف الذي نفذ الاسترجاع
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    /**
     * العميل المرتبط بالاسترجاع
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
}