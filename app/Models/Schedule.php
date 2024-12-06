<?php

namespace App\Models;

use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\Schedule
 *
 * @property int $id
 * @property string $schedule_name
 * @property int $user_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @method static Builder|Schedule newModelQuery()
 * @method static Builder|Schedule newQuery()
 * @method static Builder|Schedule query()
 * @method static Builder|Schedule whereCreatedAt($value)
 * @method static Builder|Schedule whereId($value)
 * @method static Builder|Schedule whereScheduleName($value)
 * @method static Builder|Schedule whereUpdatedAt($value)
 * @method static Builder|Schedule whereUserId($value)
 *
 * @mixin Eloquent
 *
 * @property int $is_default
 * @property-read User $user
 * @property-read Collection|UserSchedule[] $userSchedules
 * @property-read int|null $user_schedules_count
 *
 * @method static Builder|Schedule whereIsDefault($value)
 *
 * @property int $status
 *
 * @method static Builder|Schedule whereStatus($value)
 *
 * @property int $is_custom
 *
 * @method static Builder|Schedule loginUser()
 * @method static Builder|Schedule whereIsCustom($value)
 */
class Schedule extends Model
{
    use HasFactory;

    protected $table = 'schedules';

    /**
     * @var string[]
     */
    protected $fillable = [
        'schedule_name',
        'user_id',
        'is_default',
        'status',
        'is_custom',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'schedule_name' => 'string',
        'user_id' => 'integer',
        'is_default' => 'boolean',
        'status' => 'boolean',
        'is_custom' => 'boolean',
    ];

    public static $rules = [
        'schedule_name' => 'required|unique:schedules,schedule_name',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function userSchedules(): HasMany
    {
        return $this->hasMany(UserSchedule::class, 'schedule_id');
    }

    public function scopeLoginUser($query)
    {
        $query->where('user_id', getLogInUserId());
    }
}
