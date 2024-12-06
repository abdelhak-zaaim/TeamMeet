<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CreateGoogleEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $eventScheduleID;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($eventScheduleID)
    {
        $this->eventScheduleID = $eventScheduleID;
    }
}
