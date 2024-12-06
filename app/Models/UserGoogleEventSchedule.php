<?php

namespace App\Models;

use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\UserGoogleEventSchedule
 *
 * @property int $id
 * @property int $user_id
 * @property string $event_schedule_id
 * @property string $google_calendar_id
 * @property string $google_event_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @method static Builder|UserGoogleEventSchedule newModelQuery()
 * @method static Builder|UserGoogleEventSchedule newQuery()
 * @method static Builder|UserGoogleEventSchedule query()
 * @method static Builder|UserGoogleEventSchedule whereCreatedAt($value)
 * @method static Builder|UserGoogleEventSchedule whereEventScheduleId($value)
 * @method static Builder|UserGoogleEventSchedule whereGoogleCalendarId($value)
 * @method static Builder|UserGoogleEventSchedule whereGoogleEventId($value)
 * @method static Builder|UserGoogleEventSchedule whereId($value)
 * @method static Builder|UserGoogleEventSchedule whereUpdatedAt($value)
 * @method static Builder|UserGoogleEventSchedule whereUserId($value)
 *
 * @mixin Eloquent
 */
class UserGoogleEventSchedule extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'user_google_event_schedules';

    /**
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'event_schedule_id',
        'google_calendar_id',
        'google_event_id',
        'google_meet_link',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'user_id' => 'integer',
        'event_schedule_id' => 'string',
        'google_calendar_id' => 'string',
        'google_event_id' => 'string',
        'google_meet_link' => 'string',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
