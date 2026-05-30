<?php

namespace App\Models;

use App\Models\Restaurant;
use App\Models\MenuItem;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Category Model
 *
 * أعمدة الجدول
 *
 * @property int $id
 * @property int $restaurant_id
 * @property string $name
 * @property string|null $description
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * العلاقات
 * 
 * @property-read Restaurant $restaurant
 * @property-read Collection<int, MenuItem> $menuItems
 */
class Category extends Model
{
    protected $fillable = [
        'restaurant_id',
        'name',
        'description',
    ];


    /**
     * التصنيف تابع للمطعم
     */
    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(Restaurant::class);
    }

    /**
     * التصنيف يحتوي على عدة عناصر منيو
     */
    public function menuItems(): HasMany
    {
        return $this->hasMany(MenuItem::class);
    }
}