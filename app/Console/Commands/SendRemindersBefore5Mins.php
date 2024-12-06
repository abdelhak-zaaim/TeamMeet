<?php

namespace App\Console\Commands;

use App\Mail\AppointmentReminderMail;
use App\Models\EventSchedule;
use App\Models\User;
use App\Repositories\ScheduleEventRepository;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

/**
 * Class SendRemindersBefore5Mins
 */
class SendRemindersBefore5Mins extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reminders before 5 mins';

    private $scheduleEventRepo;

    /**
     * Create a new command instance.
     */
    public function __construct(ScheduleEventRepository $scheduleEventRepository)
    {
        parent::__construct();
        $this->scheduleEventRepo = $scheduleEventRepository;
    }

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $now = Carbon::now()->format('Y-m-d');
        $appointments = EventSchedule::with(['user', 'event'])
            ->whereScheduleDate($now)
            ->where('reminder_sent', false)
            ->get();

        $date = '1996-04-20';
        /** @var EventSchedule $appointment */
        foreach ($appointments as $appointment) {
            $timezone = User::TIME_ZONE_ARRAY[$appointment->user->timezone];
            $time = Carbon::now($timezone)->format('h:i a');

            $userTime = Carbon::parse($date.' '.$time, $timezone);

            $explode = explode('-', $appointment->slot_time);
            $slotStartTime = Carbon::parse($date.' '.$explode[0])->format('h:i a');
            $startTime = Carbon::parse($date.' '.$slotStartTime, $timezone);
            $data['name'] = $appointment->name;
            $data['eventName'] = $appointment->event->name;
            $data['scheduleDate'] = $appointment->schedule_date;
            $data['scheduleTime'] = $appointment->slot_time;

            $diff = $userTime->diffInMinutes($startTime);

            if ($diff == config('app.send_before')) {
                $appointment->update(['reminder_sent' => true]);
                Mail::to($appointment->email)->send(new AppointmentReminderMail($data));
            }
        }
    }
}
