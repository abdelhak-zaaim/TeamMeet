<?php

namespace App\Mail;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AppointmentReminderMail extends Mailable
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
        $name = $this->data['name'];
        $eventName = $this->data['eventName'];
        $eventScheduleDate = Carbon::parse($this->data['scheduleDate'])->translatedFormat('F j, Y');
        $eventScheduleTime = $this->data['scheduleTime'];
        $subject = 'Appointment reminder sent Successfully';

        return $this->view('emails.appointment_reminder_mail',
            compact('name', 'eventScheduleDate', 'eventScheduleTime', 'eventName'))
            ->markdown('emails.appointment_reminder_mail')
            ->subject($subject);
    }
}
