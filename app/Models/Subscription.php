<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 * Class Subscription
 *
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property int|null $subscription_plan_id
 * @property string|null $start_date
 * @property string|null $end_date
 * @property string|null $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read SubscriptionPlan|null $SubscriptionPlan
 *
 * @method static Builder|Subscription newModelQuery()
 * @method static Builder|Subscription newQuery()
 * @method static Builder|Subscription query()
 * @method static Builder|Subscription whereCreatedAt($value)
 * @method static Builder|Subscription whereCurrentEndDate($value)
 * @method static Builder|Subscription whereCurrentStartDate($value)
 * @method static Builder|Subscription whereId($value)
 * @method static Builder|Subscription whereName($value)
 * @method static Builder|Subscription whereSubscriptionPlanId($value)
 * @method static Builder|Subscription whereUserId($value)
 */
class Subscription extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'subscriptions';

    const ACTIVE = 1;

    const INACTIVE = 0;

    const TYPE_FREE = 0;

    const TYPE_STRIPE = 1;

    const TYPE_PAYPAL = 2;

    const MANUALLY = 3;

    const PAYMENT_TYPES = [
        self::TYPE_FREE => 'Free Plan',
        self::TYPE_STRIPE => 'Stripe',
        self::TYPE_PAYPAL => 'PayPal',
        self::MANUALLY => 'Manually',
    ];

    const STATUS_ARR = [
        self::ACTIVE => 'Active',
        self::INACTIVE => 'Deactive',
    ];

    const MONTH = 'Month';

    const YEAR = 'Year';

    /**
     * @var string[]
     */
    protected $fillable = [
        'user_id', 'subscription_plan_id', 'transaction_id', 'plan_amount', 'plan_frequency', 'starts_at', 'ends_at',
        'trial_ends_at', 'status',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'user_id' => 'integer',
        'subscription_plan_id' => 'integer',
        'transaction_id' => 'integer',
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'trial_ends_at' => 'datetime',
        'status' => 'boolean',
    ];

    public function subscriptionPlan(): BelongsTo
    {
        return $this->belongsTo(SubscriptionPlan::class, 'subscription_plan_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function transactions(): HasOne
    {
        return $this->hasOne(Transaction::class, 'id', 'transaction_id');
    }

    public function isExpired(): bool
    {
        $now = Carbon::now();

        // this means the subscription is ended.
        if ((! empty($this->trial_ends_at) && $this->trial_ends_at < $now) || $this->ends_at < $now) {
            return true;
        }

        // this means the subscription is not ended.
        return false;
    }
}
