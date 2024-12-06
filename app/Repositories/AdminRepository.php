<?php

namespace App\Repositories;

use App\Models\Schedule;
use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

/**
 * Class AdminRepository
 *
 * @version October 7, 2021, 10:17 am UTC
 */
class AdminRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'first_name',
        'last_name',
        'email',
        'phone_number',
        'password',
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
    public function model(): string
    {
        return User::class;
    }

    public function store($input): bool
    {
        try {
            DB::beginTransaction();

            $input['password'] = Hash::make($input['password']);
            $input['email'] = setEmailLowerCase($input['email']);
            $input['step'] = User::STEP_3;
            $admin = User::create($input);
            $adminRole = Role::whereName('admin')->first();
            $admin->assignRole($adminRole);

            $schedule = Schedule::create([
                'schedule_name' => 'Working Hours',
                'user_id' => $admin->id,
                'is_default' => true,
                'is_custom' => true,
            ]);

            // assign the default plan to the user when they register.
            $subscriptionPlan = SubscriptionPlan::where('is_default', 1)->first();
            $trialDays = $subscriptionPlan->trial_days ?? 0;
            $subscription = [
                'user_id' => $admin->id,
                'subscription_plan_id' => $subscriptionPlan->id,
                'plan_amount' => $subscriptionPlan->price,
                'plan_frequency' => $subscriptionPlan->frequency,
                'starts_at' => Carbon::now(),
                'ends_at' => Carbon::now()->addDays($trialDays),
                'trial_ends_at' => Carbon::now()->addDays($trialDays),
                'status' => Subscription::ACTIVE,
            ];

            Subscription::create($subscription);

            if (isset($input['profile']) && ! empty($input['profile'])) {
                $admin->addMedia($input['profile'])->toMediaCollection(User::PROFILE, config('app.media_disc'));
            }

            DB::commit();

            return true;
        } catch (Exception $e) {
            DB::rollBack();

            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    public function update($input, $id): bool
    {
        try {
            DB::beginTransaction();

            $admin = User::find($id);
            $input['email'] = setEmailLowerCase($input['email']);
            $input['step'] = User::STEP_3;

            if (isset($input['password']) && ! empty($input['password'])) {
                $input['password'] = Hash::make($input['password']);
            } else {
                unset($input['password']);
            }

            $admin->update($input);

            if (isset($input['profile']) && ! empty($input['profile'])) {
                $admin->clearMediaCollection(User::PROFILE);
                $admin->media()->delete();
                $admin->addMedia($input['profile'])->toMediaCollection(User::PROFILE, config('app.media_disc'));
            }

            DB::commit();

            return true;
        } catch (Exception $e) {
            DB::rollBack();
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }
}
