<?php

namespace App\Models;

use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\GoogleCalendarIntegration
 *
 * @property int $id
 * @property int $user_id
 * @property string $access_token
 * @property mixed $meta
 * @property string $last_used_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @method static Builder|GoogleCalendarIntegration newModelQuery()
 * @method static Builder|GoogleCalendarIntegration newQuery()
 * @method static Builder|GoogleCalendarIntegration query()
 * @method static Builder|GoogleCalendarIntegration whereAccessToken($value)
 * @method static Builder|GoogleCalendarIntegration whereCreatedAt($value)
 * @method static Builder|GoogleCalendarIntegration whereId($value)
 * @method static Builder|GoogleCalendarIntegration whereLastUsedAt($value)
 * @method static Builder|GoogleCalendarIntegration whereMeta($value)
 * @method static Builder|GoogleCalendarIntegration whereUpdatedAt($value)
 * @method static Builder|GoogleCalendarIntegration whereUserId($value)
 *
 * @mixin Eloquent
 */
class GoogleCalendarIntegration extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'google_calendar_integrations';

    /**
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'access_token',
        'meta',
        'last_used_at',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'user_id' => 'integer',
        'access_token' => 'string',
        'meta' => 'string',
        'last_used_at' => 'string',
    ];
}
