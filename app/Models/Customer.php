<?php

namespace App\Models;

use App\Models\Order;
use App\Models\Reservation;
use App\Models\Wallet;
use App\Models\Refund;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Customer Model
 *
 * أعمدة الجدول
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string|null $phone
 * @property string|null $email
 * @property Carbon|null $birth_date
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * العلاقات
 *
 * @property-read Collection<int, Order> $orders
 * @property-read Collection<int, Reservation> $reservations
 * @property-read Wallet|null $wallet
 * @property-read Collection<int, Refund> $refunds
 */
class Customer extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'email',
        'birth_date',
    ];

    protected $casts = [
        'birth_date' => 'date',
    ];

    /**
     * طلبات العميل
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * حجوزات العميل
     */
    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }

    /**
     * محفظة العميل (One To One)
     */
    public function wallet(): HasOne
    {
        return $this->hasOne(Wallet::class);
    }

    /**
    * مسترجعات العميلٍٍٍ
    */
    public function refunds(): HasMany
    {
        return $this->hasMany(Refund::class);
    }
}