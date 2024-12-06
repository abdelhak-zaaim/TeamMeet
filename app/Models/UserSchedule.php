<?php

namespace App\Models;

use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\UserSchedule
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $from_time
 * @property string|null $to_time
 * @property int|null $day_of_week
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @method static Builder|UserSchedule newModelQuery()
 * @method static Builder|UserSchedule newQuery()
 * @method static Builder|UserSchedule query()
 * @method static Builder|UserSchedule whereCreatedAt($value)
 * @method static Builder|UserSchedule whereDayOfWeek($value)
 * @method static Builder|UserSchedule whereFromTime($value)
 * @method static Builder|UserSchedule whereId($value)
 * @method static Builder|UserSchedule whereToTime($value)
 * @method static Builder|UserSchedule whereUpdatedAt($value)
 * @method static Builder|UserSchedule whereUserId($value)
 *
 * @mixin Eloquent
 *
 * @property int|null $schedule_id
 * @property int|null $event_id
 * @property string|null $duration
 * @property string|null $before_event_time
 * @property string|null $after_event_time
 *
 * @method static Builder|UserSchedule whereAfterEventTime($value)
 * @method static Builder|UserSchedule whereBeforeEventTime($value)
 * @method static Builder|UserSchedule whereDuration($value)
 * @method static Builder|UserSchedule whereEventId($value)
 * @method static Builder|UserSchedule whereScheduleId($value)
 *
 * @property int $check_tab
 *
 * @method static Builder|UserSchedule user()
 * @method static Builder|UserSchedule whereCheckTab($value)
 *
 * @property int $check_default
 *
 * @method static Builder|UserSchedule whereCheckDefault($value)
 */
class UserSchedule extends Model
{
    use HasFactory;

    protected $table = 'user_schedules';

    /**
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'from_time',
        'to_time',
        'day_of_week',
        'schedule_id',
        'event_id',
        'check_tab',
        'check_default',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'user_id' => 'integer',
        'from_time' => 'string',
        'to_time' => 'string',
        'day_of_week' => 'integer',
        'schedule_id' => 'integer',
        'event_id' => 'integer',
        'check_tab' => 'boolean',
        'check_default' => 'boolean',
    ];

    const Mon = 1;

    const Tue = 2;

    const Wed = 3;

    const Thu = 4;

    const Fri = 5;

    const Sat = 6;

    const Sun = 7;

    const WEEKDAY = [
        self::Mon => 'MON',
        self::Tue => 'TUE',
        self::Wed => 'WED',
        self::Thu => 'THU',
        self::Fri => 'FRI',
        self::Sat => 'SAT',
        self::Sun => 'SUN',
    ];

    const WEEKDAY_FULL_NAME = [
        self::Mon => 'Monday',
        self::Tue => 'Tuesday',
        self::Wed => 'Wednesday',
        self::Thu => 'Thursday',
        self::Fri => 'Friday',
        self::Sat => 'Saturday',
        self::Sun => 'Sunday',
    ];

    const SCHEDULE_DURATION_TIME = [
        '15' => '15 min',
        '30' => '30 min',
        '45' => '45 min',
        '60' => '60 min',
    ];

    const SCHEDULE_TIME_SLOT_ARR = [
        '5' => '5 min',
        '10' => '10 min',
        '15' => '15 min',
        '20' => '20 min',
        '30' => '30 min',
        '45' => '45 min',
        '60' => '60 min',
    ];

    const EVENT_GAP_SLOT_TIME_ARR = [
        '5' => '5 min',
        '10' => '10 min',
        '15' => '15 min',
        '20' => '20 min',
        '30' => '30 min',
        '45' => '45 min',
        '60' => '60 min',
        '90' => '1 Hr 30 Min',
        '120' => '2 Hr',
        '150' => '2 Hr 30 min',
        '180' => '3 Hr',
    ];

    const EXISTING_SCHEDULE = 0;

    const CUSTOM_SCHEDULE = 1;

    public function scopeUser($query)
    {
        $query->where('user_id', getLogInUserId());
    }
}
