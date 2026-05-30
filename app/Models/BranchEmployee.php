<?php

namespace App\Models;

use App\Models\Branch;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * BranchEmployee Model
 *
 * أعمدة الجدول
 *
 * @property int $id
 * @property int $branch_id
 * @property int $employee_id
 * @property bool $is_primary
 * @property Carbon|null $assigned_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * العلاقات
 *
 * @property-read Branch $branch
 * @property-read Employee $employee
 */
class BranchEmployee extends Model
{
    protected $table = 'branch_employee';

    protected $fillable = [
        'branch_id',
        'employee_id',
        'is_primary',
        'assigned_at',
    ];

    protected $casts = [
        'is_primary' => 'boolean',
        'assigned_at' => 'datetime',
    ];

    /**
     * العلاقة مع الفرع
     */
    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    /**
     * العلاقة مع الموظف
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}