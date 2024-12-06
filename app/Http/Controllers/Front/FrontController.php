<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\CreateFrontUserRequest;
use App\Models\PersonalExperience;
use App\Models\Schedule;
use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use App\Models\User;
use App\Models\UserSchedule;
use Carbon\Carbon;
use Flash;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class FrontController extends AppBaseController
{
    /**
     * @return Application|Factory|View
     */
    public function signUp(): \Illuminate\View\View
    {
        return view('stepper.front_sign_up');
    }

    public function signUpStore(CreateFrontUserRequest $request): \Illuminate\View\View
    {
        $input = $request->all();
        $input['password'] = hash::make($input['password']);
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
        $subscriptionPlan = SubscriptionPlan::where('is_default', 1)->first();
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

        $user->sendEmailVerificationNotification();

        Flash::success(__('messages.success_message.new_user_registered'));

        return view('stepper.email_verified_page', compact('user'));
    }

    /**
     * @return Application|Factory|View|RedirectResponse
     */
    public function customerOnBoard()
    {
        if (getLogInUser()->step == User::STEP_3) {
            return redirect()->back();
        }

        $personalExperiences = PersonalExperience::toBase()->pluck('name', 'id')->toArray();
        $dayOfWeeks = UserSchedule::WEEKDAY_FULL_NAME;
        $userSchedule = UserSchedule::user()->first();
        $selectedDayOfWeeks = UserSchedule::user()->pluck('day_of_week')->toArray();

        return view('stepper.stepper',
            compact('personalExperiences', 'dayOfWeeks', 'userSchedule', 'selectedDayOfWeeks'));
    }

    public function store(Request $request): JsonResponse
    {
        $input = $request->all();
        $message = '';

        if ($input['step'] == User::STEP_1) {
            $validated = $request->validate([
                'domain_url' => 'required|regex:/^[A-Za-z0-9\-]+$/|unique:users,domain_url,'.getLogInUserId(),
            ]);
        }

        if ($input['step'] == User::STEP_1 && (! empty($input['domain_url']) && ! ($input['timezone'] == null))) {
            $user = getLoginUser()->update([
                'domain_url' => $input['domain_url'], 'step' => $input['step'], 'timezone' => $input['timezone'],
            ]);

            $message = __('messages.success_message.first_step_completed');
        } elseif ($input['step'] == User::STEP_2) {
            $userSchedule = UserSchedule::user();

            if (isset($input['day_of_week']) && (! empty($input['from_time']) && ! empty($input['to_time']))) {
                if ($userSchedule->exists()) {
                    $userSchedule->delete();
                }

                foreach ($input['day_of_week'] as $item) {
                    UserSchedule::create([
                        'day_of_week' => $item, 'from_time' => $input['from_time'], 'to_time' => $input['to_time'],
                        'user_id' => getLogInUserId(),
                        'schedule_id' => getLogInUser()->schedule->id,
                    ]);
                }

                $user = getLoginUser()->update(['step' => $input['step']]);

                $message = __('messages.success_message.second_step_completed');
            } else {
                if ($userSchedule->exists()) {
                    $userSchedule->delete();
                }
            }
        } elseif ($input['step'] == User::STEP_3 && ! empty($input['personal_experience_id'])) {
            $user = getLogInUser()->update([
                'personal_experience_id' => $input['personal_experience_id'], 'step' => $input['step'],
            ]);

            Flash::success(__('messages.success_message.final_step_completed'));

            return $this->sendSuccess(__('messages.success_message.final_step_completed'));
        }
        $user = getLogInUser();

        return $this->sendResponse($user, $message);
    }
}
