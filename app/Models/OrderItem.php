<?php

namespace App\Models;

use App\Models\Order;
use App\Enums\OrderItemType;
use App\Models\MenuItem;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Models\OrderItemStatusHistory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * OrderItem Model
 *
 * أعمدة الجدول
 *
 * @property int $id
 * @property int $order_id
 * @property int $menu_item_id
 * @property int $quantity
 * @property float $unit_price
 * @property string|null $notes
 * @property string $type
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * العلاقات
 *
 * @property-read Order $order
 * @property-read MenuItem $menuItem
 * @property-read Collection<int, OrderItemStatusHistory> $statusHistories
 * 
 * 
 */
class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'menu_item_id',
        'quantity',
        'unit_price',
        'notes',
        'type',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'unit_price' => 'decimal:2',
        'type' => OrderItemType::class,
    ];

    /**
     * عنصر الطلب يتبع طلب
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * عنصر الطلب مرتبط بعنصر منيو
     */
    public function menuItem(): BelongsTo
    {
        return $this->belongsTo(MenuItem::class);
    }

      public function statusHistories(): HasMany
    {
        return $this->hasmany(OrderItemStatusHistory::class);
    }


}