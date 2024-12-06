<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\Transaction
 *
 * @property int $id
 * @property int $user_id
 * @property string $transaction_id
 * @property float $amount
 * @property int $type
 * @property string $meta
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read User $user
 *
 * @method static Builder|Transaction newModelQuery()
 * @method static Builder|Transaction newQuery()
 * @method static Builder|Transaction query()
 * @method static Builder|Transaction whereAmount($value)
 * @method static Builder|Transaction whereAppointmentId($value)
 * @method static Builder|Transaction whereCreatedAt($value)
 * @method static Builder|Transaction whereId($value)
 * @method static Builder|Transaction whereMeta($value)
 * @method static Builder|Transaction whereTransactionId($value)
 * @method static Builder|Transaction whereType($value)
 * @method static Builder|Transaction whereUpdatedAt($value)
 * @method static Builder|Transaction whereUserId($value)
 *
 * @mixin Model
 */
class Transaction extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'transactions';

    /**
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'transaction_id',
        'schedule_event_id',
        'amount',
        'meta',
        'type',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'user_id' => 'integer',
        'transaction_id' => 'string',
        'schedule_event_id' => 'integer',
        'amount' => 'double',
        'meta' => 'string',
        'type' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scheduleEvent(): BelongsTo
    {
        return $this->belongsTo(EventSchedule::class);
    }
}
