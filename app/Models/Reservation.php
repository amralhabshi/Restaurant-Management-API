<?php

namespace App\Models;
use App\Enums\ReservationStatus;
use App\Models\Employee;
use App\Models\Customer;
use App\Models\Table;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;


/**
 * Reservation Model
 *
 * أعمدة الجدول
 *
 * @property int $id
 * @property int $employee_id
 * @property int|null $customer_id
 * @property Carbon $start_time
 * @property int $duration_in_minutes
 * @property Carbon $end_time
 * @property string $total_price
 * @property int $guest_count
 * @property string $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * العلاقات
 *
 * @property-read Employee $employee
 * @property-read Customer|null $customer
 * @property-read Collection<int, Table> $tables
 * @property-read Order|null $order
 */
class Reservation extends Model
{
    protected $fillable = [
        'employee_id',
        'customer_id',
        'start_time',
        'duration_in_minutes',
        'total_price',
        'end_time',
        'guest_count',
        'status',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'duration_in_minutes' => 'integer',
        'total_price' => 'decimal:2',
        'guest_count' => 'integer',
        'status' => ReservationStatus::class,
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    /**
     * الحجز مرتبط بعميل
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
    /**
     * الحجز يحتوي عدة طاولات
     */
    public function tables(): BelongsToMany
    {
        return $this->belongsToMany(Table::class);  
    }

    /**
     * الحجز قد يتحول إلى طلب
     */
    public function order(): HasOne
    {
        return $this->hasOne(Order::class);
    }
    
    /**
     * هل تم تحويل الحجز إلى طلب
     */
    public function isConverted(): bool
    {
        return $this->order()->exists();
    }
}