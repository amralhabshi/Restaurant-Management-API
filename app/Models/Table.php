<?php

namespace App\Models;

use App\Enums\TableStatus;
use App\Enums\TableType;
use App\Models\Branch;
use App\Models\Order;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Table Model
 *
 * أعمدة الجدول
 *
 * @property int $id
 * @property int $branch_id
 * @property string $table_number
 * @property string $type
 * @property float $price
 * @property int $capacity
 * @property string $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * العلاقات
 *
 * @property-read Branch $branch
 * @property-read Collection<int, Reservation> $reservations
 * @property-read Collection<int, Order> $orders
 */
class Table extends Model
{
    protected $fillable = [
        'branch_id',
        'table_number',
        'type',
        'capacity',
        'price',
        'status',
    ];

    protected $casts = [
        'type' => TableType::class,
        'capacity' => 'integer',
        'price' => 'decimal:2',
        'status' => TableStatus::class,
    ];

    /**
     * الطاولة تتبع فرع
     */
    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    /**
     * الطاولة تدخل في عدة حجوزات
     */
    public function reservations(): BelongsToMany
    {
        return $this->belongsToMany(Reservation::class);
    }     

    /**
     * الطاولة تستخدم في الطلبات
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}