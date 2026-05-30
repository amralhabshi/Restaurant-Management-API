<?php

namespace App\Models;

use App\Models\OrderItem;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * OrderItemStatusHistory Model
 *
 * أعمدة الجدول
 *
 * @property int $id
 * @property int $order_item_id
 * @property int|null $employee_id
 * @property string|null $old_status
 * @property string $new_status
 * @property string|null $notes
 * @property Carbon $changed_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * العلاقات
 *
 * @property-read OrderItem $orderItem
 * @property-read Employee|null $employee
 */
class OrderItemStatusHistory extends Model
{
    protected $fillable = [
        'order_item_id',
        'employee_id',
        'old_status',
        'new_status',
        'notes',
        'changed_at',
    ];

    protected $casts = [
        'changed_at' => 'datetime',
    ];

    /**
     * السجل يتبع عنصر طلب
     */
    public function orderItem(): BelongsTo
    {
        return $this->belongsTo(OrderItem::class);
    }

    /**
     * الموظف الذي غيّر الحالة
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}