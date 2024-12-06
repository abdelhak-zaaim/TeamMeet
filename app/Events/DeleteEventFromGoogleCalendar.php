<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DeleteEventFromGoogleCalendar
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;

    public $userEventSchedule;

    /**
     * Create a new event instance.
     */
    public function __construct($userEventSchedule, $user)
    {
        $this->userEventSchedule = $userEventSchedule;
        $this->user = $user;
    }
}
