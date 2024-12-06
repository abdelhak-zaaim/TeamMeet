<?php

namespace App\Mail;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DeleteEventMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $view, string $subject, array $data = [])
    {
        $this->data = $data;
        $this->view = $view;
        $this->subject = $subject;
    }

    /**
     * Build the message.
     */
    public function build(): static
    {
        $timeZone = isset(getLoginUser()->timezone) ?
            User::TIME_ZONE_ARRAY[getLoginUser()->timezone] : User::TIME_ZONE_ARRAY[getTimeZone()];
        date_default_timezone_set($timeZone);
        $eventName = $this->data[0]['name'];
        $userName = $this->data[1]['name'];
        $timeSlot = $this->data[1]['slot_time'];
        $slotDate = Carbon::parse($this->data[1]['schedule_date'])->translatedFormat('F j, Y').', '.Carbon::parse($this->data[1]['schedule_date'])->translatedFormat('l');

        return $this->view($this->view,
            compact('eventName', 'userName', 'timeSlot', 'slotDate'))
            ->markdown($this->view)
            ->subject($this->subject);
    }
}
