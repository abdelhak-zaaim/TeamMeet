<?php

namespace App\Models;

use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\PlanFeature
 *
 * @property int $id
 * @property int|null $subscription_plan_id
 * @property string $events
 * @property string $schedule_events
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @method static Builder|PlanFeature newModelQuery()
 * @method static Builder|PlanFeature newQuery()
 * @method static Builder|PlanFeature query()
 * @method static Builder|PlanFeature whereCreatedAt($value)
 * @method static Builder|PlanFeature whereEvents($value)
 * @method static Builder|PlanFeature whereId($value)
 * @method static Builder|PlanFeature whereScheduleEvents($value)
 * @method static Builder|PlanFeature whereSubscriptionPlanId($value)
 * @method static Builder|PlanFeature whereUpdatedAt($value)
 *
 * @mixin Eloquent
 */
class PlanFeature extends Model
{
    use HasFactory;

    protected $table = 'subscription_plans_features';

    /**
     * @var string[]
     */
    protected $fillable = [
        'subscription_plan_id',
        'events',
        'schedule_events',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'subscription_plan_id' => 'integer',
        'events' => 'string',
        'schedule_events' => 'string',
    ];
}
