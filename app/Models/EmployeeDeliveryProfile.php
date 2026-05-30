<?php

namespace App\Models;

use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * EmployeeDeliveryProfile Model
 *
 * أعمدة الجدول
 *
 * @property int $id
 * @property int $employee_id
 * @property float $commission_amount
 * @property bool $is_available
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * العلاقات
 *
 * @property-read Employee $employee
 */
class EmployeeDeliveryProfile extends Model
{
    protected $fillable = [
        'employee_id',
        'commission_amount',
        'is_available',
    ];

    protected $casts = [
        'commission_amount' => 'decimal:2',
        'is_available' => 'boolean',
    ];

    /**
     * بيانات التوصيل تتبع موظف
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}