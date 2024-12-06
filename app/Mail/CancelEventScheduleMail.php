<?php

namespace App\Mail;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CancelEventScheduleMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     */
    public function build(): static
    {
        $timeZone = isset(getLoginUser()->timezone) ?
            User::TIME_ZONE_ARRAY[getLoginUser()->timezone] : User::TIME_ZONE_ARRAY[getTimeZone()];
        date_default_timezone_set($timeZone);
        $name = $this->data['name'];
        $eventScheduleDate = Carbon::parse($this->data['schedule_date'])->translatedFormat('F j, Y').', '.Carbon::parse($this->data['schedule_date'])->translatedFormat('l');
        $eventScheduleTime = $this->data['scheduleTime'];
        $subject = 'Cancel Schedule Event Successfully';

        return $this->view('emails.cancel_event_schedule_mail',
            compact('name', 'name', 'eventScheduleDate', 'eventScheduleTime'))
            ->markdown('emails.cancel_event_schedule_mail')
            ->subject($subject);
    }
}
