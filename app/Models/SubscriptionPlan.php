<?php

namespace App\Models;

use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 * Class SubscriptionPlans
 *
 * @version December 15, 2021, 6:41 am UTC
 *
 * @property string $name
 * @property number $price
 * @property int $type
 * @property int $valid_upto
 * @property int $id
 * @property string|null $currency
 * @property int $frequency 1 = Month, 2 = Year
 * @property int $is_default
 * @property int $trial_days Default validity will be 7 trial days
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Subscription|null $plan
 * @property-read PlanFeature|null $planFeature
 * @property-read Collection|Subscription[] $subscriptions
 * @property-read int|null $subscriptions_count
 *
 * @method static Builder|SubscriptionPlan newModelQuery()
 * @method static Builder|SubscriptionPlan newQuery()
 * @method static Builder|SubscriptionPlan query()
 * @method static Builder|SubscriptionPlan whereCreatedAt($value)
 * @method static Builder|SubscriptionPlan whereCurrency($value)
 * @method static Builder|SubscriptionPlan whereFrequency($value)
 * @method static Builder|SubscriptionPlan whereId($value)
 * @method static Builder|SubscriptionPlan whereIsDefault($value)
 * @method static Builder|SubscriptionPlan whereName($value)
 * @method static Builder|SubscriptionPlan wherePrice($value)
 * @method static Builder|SubscriptionPlan whereTrialDays($value)
 * @method static Builder|SubscriptionPlan whereUpdatedAt($value)
 *
 * @mixin Eloquent
 */
class SubscriptionPlan extends Model
{
    use HasFactory;

    const TRAIL_DAYS = 7;

    const MONTH = 1;

    const YEAR = 2;

    const UNLIMITED = 3;
    
    public const PLAN_TYPE = [
        1 => 'Month',
        2 => 'Year',
        3 => 'Unlimited',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|max:50|unique:subscription_plans,name',
        'price' => 'required|max:4|gte:0',
    ];

    /**
     * @var string
     */
    public $table = 'subscription_plans';

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'currency',
        'price',
        'frequency',
        'is_default',
        'trial_days',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'name' => 'string',
        'currency' => 'string',
        'price' => 'double',
        'frequency' => 'integer',
        'is_default' => 'boolean',
        'trial_days' => 'integer',
    ];

    public function plan(): HasOne
    {
        return $this->hasOne(Subscription::class)->latest();
    }

    public function plans(): HasMany
    {
        return $this->hasMany(Subscription::class)->where('user_id', getLogInUserId());
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class)->where('status', '=', Subscription::ACTIVE);
    }

    public function planFeature(): HasOne
    {
        return $this->hasOne(PlanFeature::class);
    }

    public function hasZeroPlan(): HasMany
    {
        return $this->hasMany(Subscription::class)->where('plan_amount', 0)->where('user_id', getLogInUserId());
    }
}
