<?php

namespace App\Models;

use App\Models\Branch;
use App\Models\Employee;
use App\Models\Delivery;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * DeliveryZone Model
 *
 * أعمدة الجدول
 *
 * @property int $id
 * @property int $branch_id
 * @property string $name
 * @property string|null $description
 * @property float $delivery_fee
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * العلاقات
 *
 * @property-read Branch $branch
 * @property-read Collection<int, Employee> $employees
 * @property-read Collection<int, Delivery> $deliveries
 */
class DeliveryZone extends Model
{
    protected $fillable = [
        'branch_id',
        'name',
        'description',
        'delivery_fee',
    ];

    protected $casts = [
        'delivery_fee' => 'decimal:2',
    ];

    /**
     * المنطقة تتبع فرع
     */
    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    /**
     * المندوبين داخل المنطقة
     */
    public function employees(): BelongsToMany
    {
        return $this->belongsToMany(Employee::class);
    }

    /**
     * عمليات التوصيل التابعة للمنطقة
     */
    public function deliveries(): HasMany
    {
        return $this->hasMany(Delivery::class);
    }
}