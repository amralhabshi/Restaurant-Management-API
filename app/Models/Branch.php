<?php

namespace App\Models;

use App\Models\Restaurant;
use App\Models\Employee;
use App\Models\Table;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Branch Model
 *
 * أعمدة الجدول
 *
 * @property int $id
 * @property int $restaurant_id
 * @property string $name
 * @property string|null $phone
 * @property string $city
 * @property string $address
 * @property string $opening_time
 * @property string $closing_time
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * العلاقات
 *
 * @property-read Restaurant $restaurant
 * @property-read Collection<int, Employee> $employees
 * @property-read Collection<int, Table> $tables
 * @property-read Collection<int, Order> $orders
 */
class Branch extends Model
{
    protected $fillable = [
        'restaurant_id',
        'name',
        'phone',
        'city',
        'address',
        'opening_time',
        'closing_time',
        'is_main',
    ];

    protected $casts = [
        'is_main'=>'boolean'
    ];

    /**
     * الفرع تابع لمطعم
     */
    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(Restaurant::class);
    }

    /**
     * الموظف يعمل في اكثر من فرع
     */
    public function employees(): BelongsToMany
    {
        return $this->belongsToMany(Employee::class)
            ->withPivot([
                'is_primary',
                'assigned_at',
            ])
            ->withTimestamps();
    }   

    /**
     * الطاولات داخل الفرع
     */
    public function tables(): HasMany
    {
        return $this->hasMany(Table::class);
    }

    /**
     * الطلبات داخل الفرع
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}