<?php

namespace App\Models;

use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\EventGoogleCalendar
 *
 * @property-read GoogleCalendarList $googleCalendarList
 *
 * @method static Builder|EventGoogleCalendar newModelQuery()
 * @method static Builder|EventGoogleCalendar newQuery()
 * @method static Builder|EventGoogleCalendar query()
 *
 * @mixin Eloquent
 *
 * @property int $id
 * @property int $user_id
 * @property int $google_calendar_list_id
 * @property string $google_calendar_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @method static Builder|EventGoogleCalendar whereCreatedAt($value)
 * @method static Builder|EventGoogleCalendar whereGoogleCalendarId($value)
 * @method static Builder|EventGoogleCalendar whereGoogleCalendarListId($value)
 * @method static Builder|EventGoogleCalendar whereId($value)
 * @method static Builder|EventGoogleCalendar whereUpdatedAt($value)
 * @method static Builder|EventGoogleCalendar whereUserId($value)
 */
class EventGoogleCalendar extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'event_google_calendars';

    /**
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'google_calendar_list_id',
        'google_calendar_id',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'user_id' => 'integer',
        'google_calendar_list_id' => 'integer',
        'google_calendar_id' => 'string',
    ];

    public function googleCalendarList(): BelongsTo
    {
        return $this->BelongsTo(GoogleCalendarList::class);
    }
}
