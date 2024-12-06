<?php

namespace App\Console\Commands;

use App\Jobs\AdminEventReminders;
use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\UserSetting;
use App\Models\EventSchedule;
use App\Jobs\EventReminders;
use App\Models\Setting;
use App\Models\User;

class EventRemindersBeforeMinutes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:event-reminders-before-minutes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $currentDate = Carbon::parse(Carbon::now())->format('Y-m-d');
        // $remindertime = UserSetting::where('key', 'event_reminders_before_minutes')->value('value');
        $emails = EventSchedule::with('user')->where('schedule_date', $currentDate)->get();


        foreach ($emails as $email) {
            foreach (\App\Models\User::TIME_ZONE_ARRAY as $key =>  $value) {
                if ($key == $email->user->timezone) {
                    $currentDateTime = Carbon::now($value);
                    $formattedCurrentDateTime = $currentDateTime->format('Y-m-d h:i:s A');
                }
            }

            $remindertime = UserSetting::where('user_id',$email->user_id)->where('key','event_reminders_before_minutes')->value('value');

            $user = User::find($email->user_id);

            $timeSlot = $email->slot_time;
            $scheduleDate = $email->schedule_date;
            $startTime = explode(' - ', $timeSlot)[0];

            $dateTimeAM = Carbon::createFromFormat('Y-m-d h:i A', $scheduleDate . ' ' . $startTime);
            $formattedCurrentDateTimeCarbon = Carbon::createFromFormat('Y-m-d h:i:s A', $formattedCurrentDateTime);

            $timeDifference = $formattedCurrentDateTimeCarbon->diff($dateTimeAM);

            $days = $timeDifference->d;
            $hours = $timeDifference->h;
            $minutes = $timeDifference->i;
            $seconds = $timeDifference->s;

            $data['name'] = $email->name;
            $data['email'] = $email->email;
            $data['eventName'] = $email->event->name;
            $data['scheduleDate'] = $email->schedule_date;
            $data['scheduleTime'] = $email->slot_time;
            $data['remindertime'] = $remindertime;
            $data['adminEmail'] = $user->email;
            $data['adminName'] = $user->first_name. ' '. $user->last_name;

            if ($hours == 0 && $minutes == $remindertime) {
                dispatch(new EventReminders($data));
                if($data['adminEmail']){
                    dispatch(new AdminEventReminders($data));

                }

            }
        }
    }
}
