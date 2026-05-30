<?php

namespace App\Models;

use App\Models\Branch;
use App\Models\Employee;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Restaurant Model
 *
 * أعمدة الجدول
 *
 * @property int $id
 * @property string $name
 * @property string|null $phone
 * @property string|null $email
 * @property string|null $description
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * العلاقات
 *
 * @property-read Collection<int, Branch> $branches
 * @property-read Collection<int, Branch> $employees
 * @property-read Collection<int, Branch> $categories
 * 
 */
class Restaurant extends Model
{
    /**
     * الحقول القابلة للتعبئة
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'phone',
        'email',
        'description',
    ];

    /**
     * المطعم لديه عدة فروع
     */
    public function branches(): HasMany
    {
        return $this->hasMany(Branch::class);
    }

    /**
     * المطعم لديه عدة موظفين
     */
    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class);
    }

    /**
     * المطعم لديه عدة تصنيفات للطعام
     */
    public function categories(): HasMany
    {
        return $this->hasMany(Category::class);
    }
}