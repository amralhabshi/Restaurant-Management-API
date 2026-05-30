<?php

namespace App\Models;

use App\Models\Delivery;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * DeliveryStatusHistory Model
 *
 * أعمدة الجدول
 *
 * @property int $id
 * @property int $delivery_id
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
 * @property-read Delivery $delivery
 * @property-read Employee|null $employee
 */
class DeliveryStatusHistory extends Model
{
    /**
     * الحقول القابلة للتعبئة
     *
     * @var list<string>
     */
    protected $fillable = [
        'delivery_id',
        'employee_id',
        'old_status',
        'new_status',
        'notes',
        'changed_at',
    ];

    /**
     * تحويل أنواع البيانات تلقائيًا
     *
     * @var array<string, string>
     */
    protected $casts = [
        'changed_at' => 'datetime',
    ];

    /**
     * السجل يتبع عملية توصيل
     */
    public function delivery(): BelongsTo
    {
        return $this->belongsTo(Delivery::class);
    }

    /**
     * الموظف الذي غيّر الحالة
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}