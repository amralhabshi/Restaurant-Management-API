<?php

namespace App\Models;

use App\Models\Category;
use App\Models\OrderItem;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * MenuItem Model
 *
 * أعمدة الجدول
 *
 * @property int $id
 * @property int $category_id
 * @property string $name
 * @property string|null $description
 * @property float $price
 * @property int $preparation_time
 * @property bool $is_available
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * العلاقات
 *
 * @property-read Category $category
 * @property-read Collection<int, OrderItem> $orderItems
 */
class MenuItem extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'description',
        'price',
        'preparation_time',
        'is_available',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'preparation_time' => 'integer',
        'is_available' => 'boolean',
    ];

    /**
     * العنصر يتبع تصنيف
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * العنصر يظهر في عدة طلبات
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}