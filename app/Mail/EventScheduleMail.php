<?php

namespace App\Mail;

use App\Models\Event;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EventScheduleMail extends Mailable
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
    public function build(): EventScheduleMail
    {
        $loginUserName = $this->data['loginUserName'];
        $eventName = $this->data['event'];
        $googleMeetLink = $this->data['googleMeetLink'];
        $name = $this->data['name'];
        $email = $this->data['email'];
        $user = $this->data['user'];
        $confirmScheduleEventUrl = $this->data['confirmScheduleEventUrl'];
        $cancelScheduleEventUrl = $this->data['cancelScheduleEventUrl'];
        $eventScheduleDate = Carbon::parse($this->data['schedule_date'])->translatedFormat('F j, Y').', '.Carbon::parse($this->data['schedule_date'])->translatedFormat('l');
        $eventScheduleTime = $this->data['scheduleTime'];
        $subject = 'Event Scheduled Successfully';

        if ($this->data['eventType'] == Event::PAID) {
            $data['scheduleEvent'] = $this->data['eventSchedule'];
            $data['user'] = $this->data['user'];
            $scheduleEventPdf = PDF::loadView('schedule_event.schedule_event_pdf', $data);

            return $this->view('emails.confirm_event_schedule_mail',
                compact('email', 'loginUserName', 'name', 'eventName', 'eventScheduleDate', 'eventScheduleTime',
                    'confirmScheduleEventUrl', 'cancelScheduleEventUrl', 'googleMeetLink'))
                ->markdown('emails.confirm_event_schedule_mail')
                ->subject($subject)
                ->attachData($scheduleEventPdf->output(), 'schedule-invoice.pdf');
        }

        return $this->view('emails.confirm_event_schedule_mail',
            compact('email', 'loginUserName', 'name', 'eventName', 'eventScheduleDate', 'eventScheduleTime',
                'confirmScheduleEventUrl', 'cancelScheduleEventUrl', 'googleMeetLink'))
            ->markdown('emails.confirm_event_schedule_mail')
            ->subject($subject);
    }
}
