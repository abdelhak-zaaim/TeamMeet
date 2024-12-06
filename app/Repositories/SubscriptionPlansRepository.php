<?php

namespace App\Repositories;

use App\Models\PlanFeature;
use App\Models\SubscriptionPlan;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

/**
 * Class SubscriptionPlansRepository
 *
 * @version December 15, 2021, 6:41 am UTC
 */
class SubscriptionPlansRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'price',
        'type',
        'valid_upto',
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

    public function store($input)
    {
        try {
            DB::beginTransaction();

            $planInput = Arr::except($input, ['events', 'schedule_events']);
            $planInput['trial_days'] = ! empty($planInput['trial_days']) ? $planInput['trial_days'] : 0;
            $subscriptionPlan = SubscriptionPlan::create($planInput);

            $input['subscription_plan_id'] = $subscriptionPlan->id;
            $planFeature = PlanFeature::create($input);

            DB::commit();

            return $subscriptionPlan;
        } catch (Exception $e) {
            DB::rollBack();
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    public function update($input, $id)
    {
        try {
            DB::beginTransaction();

            $planInput = Arr::except($input, ['_method', '_token', 'events', 'schedule_events']);
            $subscriptionPlan = SubscriptionPlan::findOrFail($id);
            $planInput['trial_days'] = ! empty($planInput['trial_days']) ? $planInput['trial_days'] : 0;
            $subscriptionPlan->update($planInput);

            $featureInput = Arr::except($input,
                ['_method', '_token', 'name', 'currency', 'price', 'frequency', 'trial_days']);
            $planFeature = PlanFeature::whereSubscriptionPlanId($subscriptionPlan->id);
            $featureInput['subscription_plan_id'] = $subscriptionPlan->id;
            $planFeature->update($featureInput);

            DB::commit();

            return $subscriptionPlan;
        } catch (Exception $e) {
            DB::rollBack();
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    /**
     * @return string[]
     */
    public function planType(): array
    {
        return SubscriptionPlan::PLAN_TYPE;
    }
}
