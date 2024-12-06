<?php

namespace App\Models;

use Database\Factories\EventFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 * Class Event
 *
 * @version October 27, 2021, 6:47 am UTC
 *
 * @property int $id
 * @property string $name
 * @property int $event_location
 * @property string|null $description
 * @property string|null $event_link
 * @property string|null $event_color
 * @property mixed|null $location_meta
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @method static EventFactory factory(...$parameters)
 * @method static Builder|Event newModelQuery()
 * @method static Builder|Event newQuery()
 * @method static Builder|Event query()
 * @method static Builder|Event whereCreatedAt($value)
 * @method static Builder|Event whereDescription($value)
 * @method static Builder|Event whereEventColor($value)
 * @method static Builder|Event whereEventLink($value)
 * @method static Builder|Event whereEventLocation($value)
 * @method static Builder|Event whereId($value)
 * @method static Builder|Event whereLocationMeta($value)
 * @method static Builder|Event whereName($value)
 * @method static Builder|Event whereUpdatedAt($value)
 *
 * @property int|null $schedule_id
 * @property int $user_id
 *
 * @method static Builder|Event whereScheduleId($value)
 * @method static Builder|Event whereUserId($value)
 *
 * @property string $slot_time
 * @property string $before_event_time
 * @property string $after_event_time
 * @property string|null $max_event_per_day
 * @property int $secret_event
 * @property-read Collection|UserSchedule[] $userSchedules
 * @property-read int|null $user_schedules_count
 *
 * @method static Builder|Event whereAfterEventTime($value)
 * @method static Builder|Event whereBeforeEventTime($value)
 * @method static Builder|Event whereDuration($value)
 * @method static Builder|Event whereMaxEventPerDay($value)
 * @method static Builder|Event whereSecretEvent($value)
 * @method static Builder|Event whereSlotTime($value)
 *
 * @property string|null $schedule_days
 * @property string|null $schedule_from
 * @property string|null $schedule_to
 *
 * @method static Builder|Event whereScheduleDays($value)
 * @method static Builder|Event whereScheduleFrom($value)
 * @method static Builder|Event whereScheduleTo($value)
 *
 * @property int $date_range
 * @property int $status
 * @property-read EventSchedule|null $eventSchedule
 *
 * @method static Builder|Event whereDateRange($value)
 * @method static Builder|Event whereStatus($value)
 *
 * @property string|null $gap_slot
 * @property int|null $event_type
 * @property float|null $payable_amount
 * @property-read User $user
 *
 * @method static Builder|Event whereEventType($value)
 * @method static Builder|Event whereGapSlot($value)
 * @method static Builder|Event wherePayableAmount($value)
 */
class Event extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'events';

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'event_location',
        'description',
        'event_link',
        'event_color',
        'location_meta',
        'user_id',
        'schedule_id',
        'slot_time',
        'gap_slot',
        'max_event_per_day',
        'secret_event',
        'schedule_days',
        'schedule_from',
        'schedule_to',
        'date_range',
        'status',
        'event_type',
        'payable_amount',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'name' => 'string',
        'event_location' => 'integer',
        'description' => 'string',
        'event_link' => 'string',
        'event_color' => 'string',
        'location_meta' => 'string',
        'user_id' => 'integer',
        'schedule_id' => 'integer',
        'slot_time' => 'string',
        'gap_slot' => 'string',
        'max_event_per_day' => 'string',
        'secret_event' => 'boolean',
        'schedule_days' => 'string',
        'schedule_from' => 'string',
        'schedule_to' => 'string',
        'date_range' => 'boolean',
        'status' => 'boolean',
        'event_type' => 'integer',
        'payable_amount' => 'double',
    ];

    const IN_PERSON_MEETING = 1;

    const UNLIMITED_EVENT = -1;

    const PHONE_CALL = 2;

    const GOOGLE_MEET = 3;

    const ACTIVE = 1;

    const DE_ACTIVE = 0;

    const LOCATION_ARRAY = [
        self::IN_PERSON_MEETING => 'In Person Meeting',
        self::PHONE_CALL => 'Phone Call',
        self::GOOGLE_MEET => 'Google Meet',
    ];

    const FREE = 1;

    const PAID = 2;

    const EVENT_TYPE = [
        self::FREE => 'Free',
        self::PAID => 'Paid',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|unique:events,name',
        'event_location' => 'required',
        'event_link' => 'required|regex:/^[A-Za-z0-9\-]+$/|unique:events,event_link',
        'event_color' => 'required',
    ];

    public function userSchedules(): HasMany
    {
        return $this->hasMany(UserSchedule::class, 'event_id');
    }

    public function eventSchedule(): HasOne
    {
        return $this->hasOne(EventSchedule::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
