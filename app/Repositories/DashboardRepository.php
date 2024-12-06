<?php

namespace App\Repositories;

use App\Models\Event;
use App\Models\EventSchedule;
use App\Models\Schedule;
use App\Models\User;
use App\Models\UserSetting;
use Carbon\Carbon;
use Illuminate\Support\Arr;

/**
 * Class DashboardRepository
 */
class DashboardRepository
{
    /**
     * @param  null  $loginUser
     */
    public function getData($loginUser = null): array
    {
        $todayDate = Carbon::now()->format('Y-m-d');

        if (! empty($loginUser)) {
            $data['todayScheduledEvents'] = EventSchedule::with('event')
                ->where('status', '!=', EventSchedule::CANCELLED)->whereUserId($loginUser)
                ->whereScheduleDate($todayDate)->latest()->take(10)->get();
            $data['upcomingScheduledEvents'] = EventSchedule::with('event')->where('status', '!=', EventSchedule::CANCELLED)
                ->whereUserId($loginUser)->where('schedule_date', '>', $todayDate)->latest()->take(10)->get();
            $data['activeEventsCount'] = Event::whereUserId($loginUser)->whereStatus(true)->count();
            $data['activeSchedulesCount'] = Schedule::whereUserId($loginUser)->whereStatus(true)->count();
        } else {
            $data['totalUsers'] = User::role('user')->count();
            $data['totalScheduledEvents'] = EventSchedule::count();
            $data['totalActiveEvents'] = Event::whereStatus(true)->count();
        }

        return $data;
    }

    public function userUpdateSetting($id)
    {
        $inputArr['stripe'] = UserSetting::whereUserId($id)->where('key', '=', 'stripe_enable')->first();
        if ($inputArr['stripe'] == null) {
            $inputArr['stripe_enable'] = 0;
            $inputArr['stripe_key'] = null;
            $inputArr['stripe_secret'] = null;
            $inputArr['paypal_enable'] = 0;
            $inputArr['paypal_client_id'] = null;
            $inputArr['paypal_secret'] = null;
            $inputArr['paypal_mode'] = null;
            $inputArr['event_reminders_before_minutes'] = 10;
            $inputArr['paystack_enable'] = 0;
            $inputArr['paystack_key'] = null;
            $inputArr['paystack_secret'] = null;
        }

        $inputArr['razorpay'] = UserSetting::whereUserId($id)->where('key', '=', 'razorpay_enable')->first();
        if ($inputArr['razorpay'] == null) {
            $inputArr['razorpay_enable'] = 0;
            $inputArr['razorpay_key'] = null;
            $inputArr['razorpay_secret'] = null;
        }

        $inputArr = Arr::except($inputArr, ['stripe']);
        foreach ($inputArr as $key => $value) {
            /** @var UserSetting $UserSetting */
            $UserSetting = UserSetting::whereUserId(getLogInUserId())->where('key', '=', $key)->first();
            if (! $UserSetting) {
                UserSetting::create([
                    'user_id' => getLogInUserId(),
                    'key' => $key,
                    'value' => $value,
                ]);
            } else {
                $UserSetting->update(['value' => $value]);
            }
        }
    }
}
