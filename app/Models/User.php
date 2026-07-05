<?php

namespace App\Models;

use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * User Model
 *
 * أعمدة الجدول
 *
 * @property int $id
 * @property int $employee_id
 * @property string $username
 * @property string $password
 * @property bool $is_active
 * @property Carbon|null $last_login_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * العلاقات
 *
 * @property-read Employee $employee
 * @property-read Collection<int, Role> $roles
 */
class User extends Authenticatable
{
    use HasFactory;
    protected $fillable = [
        'employee_id',
        'username',
        'password',
        'is_active',
        'last_login_at',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'last_login_at' => 'datetime',
    ];

    /**
     * المستخدم مرتبط بموظف
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    /**
     * المستخدم لديه عدة أدوار
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * هل يمتلك صلاحية محددة
     */
    public function hasAnyPermission(string $permission): bool
    {
        return $this->roles()
            ->whereHas('permissions', function ($query) use ($permission) {
                $query->where('name', $permission);
            })
            ->exists();
    }

    public function restaurant(): HasOneThrough
    {
        return $this->hasOneThrough(Restaurant::class,Employee::class);
    }
}