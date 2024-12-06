<?php

namespace App\Repositories;

use App\Models\SubscriptionPlan;
use Arr;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class SubscriptionPlanRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'price',
        'valid_until',
    ];

    /**
     * Return searchable fields
     */
    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return SubscriptionPlan::class;
    }

    public function store($input): SubscriptionPlan
    {
        $subscriptionPlan = null;
        $input['trial_days'] = $input['trial_days'] != null ? $input['trial_days'] : 0;
        $input['price'] = removeCommaFromNumbers($input['price']);
        /** @var SubscriptionPlan $subscriptionPlan */
        $subscriptionPlan = SubscriptionPlan::create(Arr::except($input, ['plan_feature']));

        if (isset($input['plan_feature'])) {
            $subscriptionPlan->features()->sync($input['plan_feature']);
        }

        return $subscriptionPlan;
    }

    /**
     * @return Builder|Builder[]|Collection|Model
     */
    public function updateSubscriptionPlan(array $input, int $id)
    {
        $subscriptionPlan = SubscriptionPlan::findOrFail($id);
        $input['trial_days'] = $input['trial_days'] != null ? $input['trial_days'] : 0;
        $input['price'] = removeCommaFromNumbers($input['price']);
        $subscriptionPlan->update($input);

        $subscriptionPlan->features()->sync(isset($input['plan_feature']) ? $input['plan_feature'] : []);

        return $subscriptionPlan;
    }

    public function getSubscriptionPlansData(): array
    {
        $data = null;
        $data['subscriptionPricingMonthPlans'] = SubscriptionPlan::with([
            'plan', 'plans', 'subscriptions', 'hasZeroPlan',
        ])->where('frequency', '=', SubscriptionPlan::MONTH)
            ->get();

        $data['subscriptionPricingYearPlans'] = SubscriptionPlan::with([
            'plan', 'plans', 'subscriptions', 'hasZeroPlan',
        ])->where('frequency', '=', SubscriptionPlan::YEAR)
            ->get();

        $data['subscriptionPricingUnlimitedPlans'] = SubscriptionPlan::with([
            'plan', 'plans', 'subscriptions', 'hasZeroPlan',
        ])->where('frequency', '=', SubscriptionPlan::UNLIMITED)
            ->get();

        return $data;
    }
}
