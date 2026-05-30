<?php

namespace App\Models;

use App\Enums\DeliveryStatus;
use App\Enums\PaymentStatus;
use App\Models\Order;
use App\Models\Employee;
use App\Models\DeliveryZone;
use App\Models\DeliveryStatusHistory;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Delivery Model
 *
 * أعمدة الجدول
 *
 * @property int $id
 * @property int $order_id
 * @property int|null $employee_id
 * @property int|null $delivery_zone_id
 * @property string $customer_name
 * @property string $customer_phone
 * @property string $customer_address
 * @property string $delivery_address
 * @property string $status
 * @property string $payment_status
 * @property bool $cash_collected
 * @property Carbon|null $picked_up_at
 * @property Carbon|null $delivered_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * العلاقات
 *
 * @property-read Order $order
 * @property-read Employee|null $employee
 * @property-read DeliveryZone|null $deliveryZone
 * @property-read Collection<int, DeliveryStatusHistory> $statusHistories
 */
class Delivery extends Model
{
    /**
     * الحقول القابلة للتعبئة
     *
     * @var list<string>
     */
    protected $fillable = [
        'order_id',
        'employee_id',
        'delivery_zone_id',
        'customer_name',
        'customer_phone',
        'customer_address',
        'delivery_address',
        'status',
        'payment_status',
        'cash_collected',
        'picked_up_at',
        'delivered_at',
    ];

    /**
     * تحويل أنواع البيانات تلقائيًا
     *
     * @var array<string, string>
     */
    protected $casts = [
        'status' => DeliveryStatus::class,
        'payment_status' => PaymentStatus::class,
        'cash_collected' => 'boolean',
        'picked_up_at' => 'datetime',
        'delivered_at' => 'datetime',
    ];

    /**
     * عملية التوصيل تتبع طلب
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * المندوب المسؤول عن التوصيل
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    /**
     * منطقة التوصيل الخاصة بالطلب
     */
    public function deliveryZone(): BelongsTo
    {
        return $this->belongsTo(DeliveryZone::class);
    }

    /**
     * سجل تغييرات حالات التوصيل
     */
    public function statusHistories(): HasMany
    {
        return $this->hasMany(DeliveryStatusHistory::class);
    }
}