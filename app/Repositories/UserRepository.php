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
 * Class UserRepository
 *
 * @version October 6, 2021, 10:17 am UTC
 */
class UserRepository extends BaseRepository
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
            $user = User::create($input);
            $userRole = Role::whereName('user')->first();
            $user->assignRole($userRole);

            $schedule = Schedule::create([
                'schedule_name' => 'Working Hours',
                'user_id' => $user->id,
                'is_default' => true,
                'is_custom' => true,
            ]);

            // assign the default plan to the user when they registers.
            $subscriptionPlan = SubscriptionPlan::where('id', $input['subscription_plans_id'])->first();
            $trialDays = $subscriptionPlan->trial_days ?? 0;
            $subscription = [
                'user_id' => $user->id,
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
                $user->addMedia($input['profile'])->toMediaCollection(User::PROFILE, config('app.media_disc'));
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

            $user = User::find($id);
            $input['email'] = setEmailLowerCase($input['email']);
            if (isset($input['password']) && ! empty($input['password'])) {
                $input['password'] = Hash::make($input['password']);
            } else {
                unset($input['password']);
            }

            $user->update($input);

            if (isset($input['profile']) && ! empty($input['profile'])) {
                $user->clearMediaCollection(User::PROFILE);
                $user->media()->delete();
                $user->addMedia($input['profile'])->toMediaCollection(User::PROFILE, config('app.media_disc'));
            }

            DB::commit();

            return true;
        } catch (Exception $e) {
            DB::rollBack();
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }
}
