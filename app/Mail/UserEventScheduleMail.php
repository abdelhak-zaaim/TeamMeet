<?php

namespace App\Mail;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserEventScheduleMail extends Mailable
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
        $loginUserName = $this->data['loginUserName'];
        $eventName = $this->data['event'];
        $name = $this->data['name'];
        $email = $this->data['email'];
        $eventScheduleDate = Carbon::parse($this->data['schedule_date'])->translatedFormat('F j, Y').', '.Carbon::parse($this->data['schedule_date'])->translatedFormat('l');
        $eventScheduleTime = $this->data['scheduleTime'];
        $subject = $name.' booked an appointment on '.$eventName;

        return $this->view('emails.user_confirm_event_schedule_mail',
            compact('email', 'loginUserName', 'name', 'eventName', 'eventScheduleDate', 'eventScheduleTime'))
            ->markdown('emails.user_confirm_event_schedule_mail')
            ->subject($subject);
    }
}
