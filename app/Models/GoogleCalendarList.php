<?php

namespace App\Models;

use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\GoogleCalendarList
 *
 * @property int $id
 * @property int $user_id
 * @property string $calendar_name
 * @property string $google_calendar_id
 * @property mixed $meta
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @method static Builder|GoogleCalendarList newModelQuery()
 * @method static Builder|GoogleCalendarList newQuery()
 * @method static Builder|GoogleCalendarList query()
 * @method static Builder|GoogleCalendarList whereCalendarName($value)
 * @method static Builder|GoogleCalendarList whereCreatedAt($value)
 * @method static Builder|GoogleCalendarList whereGoogleCalendarId($value)
 * @method static Builder|GoogleCalendarList whereId($value)
 * @method static Builder|GoogleCalendarList whereMeta($value)
 * @method static Builder|GoogleCalendarList whereUpdatedAt($value)
 * @method static Builder|GoogleCalendarList whereUserId($value)
 *
 * @mixin Eloquent
 */
class GoogleCalendarList extends Model
{
    use HasFactory;

    protected $table = 'google_calendar_lists';

    /**
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'calendar_name',
        'google_calendar_id',
        'meta',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'user_id' => 'integer',
        'calendar_name' => 'string',
        'google_calendar_id' => 'string',
        'meta' => 'string',
    ];

    public function eventGoogleCalendar(): BelongsTo
    {
        return $this->belongsTo(EventGoogleCalendar::class);
    }
}
