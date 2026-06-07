<?php

namespace App\Models;
use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Permission Model
 *
 * أعمدة الجدول
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * العلاقات
 *
 * @property-read Collection<int, Role> $roles
 */
class Permission extends Model
{
    protected $fillable = [
        'name',
        'description',
    ];

    /**
     * الأدوار المرتبطة بالصلاحية
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }
}