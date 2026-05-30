<?php

namespace App\Models;

use App\Enums\OrderStatus;
use App\Enums\OrderType;
use App\Models\Branch;
use App\Models\Employee;
use App\Models\Customer;
use App\Models\Table;
use App\Models\Reservation;
use App\Models\OrderItem;
use App\Models\Invoice;
use App\Models\Delivery;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Order Model
 *
 * أعمدة الجدول
 *
 * @property int $id
 * @property int $employee_id
 * @property int|null $customer_id
 * @property int $branch_id
 * @property int|null $table_id
 * @property int|null $reservation_id
 * @property string $order_number
 * @property string $type
 * @property string $status
 * @property float $total_price
 * @property string|null $notes
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * العلاقات
 * 
 * @property-read Branch $branch
 * @property-read Employee|null $employee
 * @property-read Customer|null $customer
 * @property-read Table|null $table
 * @property-read Reservation|null $reservation
 * @property-read Collection<int, OrderItem> $orderItems
 * @property-read Invoice|null $invoice
 * @property-read Delivery|null $delivery
 */
class Order extends Model
{
    protected $fillable = [
        'employee_id',
        'customer_id',
        'branch_id',
        'table_id',
        'reservation_id',
        'order_number',
        'type',
        'status',
        'total_price',
        'notes',
    ];

    protected $casts = [
        'total_price' => 'decimal:2',
        'type' => OrderType::class,
        'status' => OrderStatus::class,
    ];

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function table(): BelongsTo
    {
        return $this->belongsTo(Table::class);
    }

    /**
     * الطلب مرتبط بحجز
     */
    public function reservation(): BelongsTo
    {
        return $this->belongsTo(Reservation::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function invoice(): HasOne
    {
        return $this->hasOne(Invoice::class);
    }

    public function delivery(): HasOne
    {
        return $this->hasOne(Delivery::class);
    }
}