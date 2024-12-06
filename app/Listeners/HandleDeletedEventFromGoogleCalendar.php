<?php

namespace App\Listeners;

use App\Repositories\GoogleCalendarRepository;

class HandleDeletedEventFromGoogleCalendar
{
    /**
     * Handle the event.
     */
    public function handle(object $userEventSchedule): void
    {
        /** @var GoogleCalendarRepository $repo */
        $repo = \App::make(GoogleCalendarRepository::class);
        $eventSchedules = $userEventSchedule->userEventSchedule;

        $repo->destroy($eventSchedules);
    }
}
