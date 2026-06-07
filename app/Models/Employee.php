<?php

namespace App\Models;

use App\Enums\EmployeeStatus;
use App\Models\Restaurant;
use App\Models\Branch;
use App\Models\Order;
use App\Models\Reservation;
use App\Models\Delivery;
use App\Models\DeliveryZone;
use App\Models\EmployeeDeliveryProfile;
use App\Models\Refund;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Employee Model
 *
 * أعمدة الجدول
 *
 * @property int $id
 * @property int $restaurant_id
 * @property string $first_name
 * @property string $last_name
 * @property string $phone
 * @property string $email
 * @property float $salary
 * @property Carbon $hire_date
 * @property string $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * العلاقات
 *
 * @property-read Restaurant $restaurant
 * @property-read Collection<int, Branch> $branches
 * @property-read Collection<int, Reservation> $reservations
 * @property-read Collection<int, Order> $orders
 * @property-read Collection<int, DeliveryZone> $deliveryZones
 * @property-read EmployeeDeliveryProfile|null $deliveryProfile
 * @property-read Collection<int, Delivery> $deliveries
 * @property-read Collection<int, Refund> $refunds
 * @property-read User $user
 * 
 */
class Employee extends Model
{
    protected $fillable = [
        'restaurant_id',
        'first_name',
        'last_name',
        'phone',
        'email',
        'salary',
        'hire_date',
        'status',
    ];

    protected $casts = [
        'hire_date' => 'date',
        'salary' => 'decimal:2',
        'status' => EmployeeStatus::class,
    ];

    /**
     * الموظف يتبع المطعم
     */
    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(Restaurant::class);
    }

    /**
     * الموظف يعمل في عدة فروع
     */
    public function branches(): BelongsToMany
    {
        return $this->belongsToMany(Branch::class)
            ->withPivot([
                'is_primary',
                'assigned_at',
            ])
            ->withTimestamps();
    }

    /**
     * الطلبات التي أنشأها الموظف
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * الحجوزات التي أنشأها الموظف
     */
    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }

    /**
     * مناطق التوصيل الخاصة بالمندوب
     */
    public function deliveryZones(): BelongsToMany
    {
        return $this->belongsToMany(DeliveryZone::class);
    }

    /**
     * بيانات التوصيل الخاصة بالمندوب
     */
    public function deliveryProfile(): HasOne
    {
        return $this->hasOne(EmployeeDeliveryProfile::class);
    }

    /**
     * عمليات التوصيل الخاصة بالمندوب
     */
    public function deliveries(): HasMany
    {
        return $this->hasMany(Delivery::class);
    }

    /**
    * عمليات الاسترجاع التي نفذها الموظف
    */
    public function refunds(): HasMany
    {
        return $this->hasMany(Refund::class);
    }

    /**
    * حساب المستخدم
    */
    public function user(): HasOne
    {
    return $this->hasOne(User::class);
    }
}