<?php

namespace App\Listeners;

use App\Models\EventGoogleCalendar;
use App\Models\EventSchedule;
use App\Models\GoogleCalendarIntegration;
use App\Models\UserGoogleEventSchedule;
use App\Repositories\GoogleCalendarRepository;
use Illuminate\Support\Facades\App;

class HandleCreatedGoogleEvent
{
    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        $eventScheduleID = $event->eventScheduleID;

        $this->createGoogleEvent($eventScheduleID);
    }

    public function createGoogleEvent($eventScheduleID): bool
    {
        $eventSchedule = EventSchedule::with(['user', 'event'])->find($eventScheduleID);
        $googleCalendarConnected = GoogleCalendarIntegration::whereUserId($eventSchedule->user->id)
            ->exists();

        if ($googleCalendarConnected) {
            /** @var GoogleCalendarRepository $repo */
            $repo = App::make(GoogleCalendarRepository::class);

            $calendarLists = EventGoogleCalendar::whereUserId($eventSchedule->user->id)
                ->pluck('google_calendar_id')
                ->toArray();

            $meta['name'] = 'Event Schedule Name : '.$eventSchedule->name;
            $meta['description'] = 'Event Name : '.$eventSchedule->event->name;
            $meta['lists'] = $calendarLists;

            $accessToken = $repo->getAccessToken($eventSchedule->user->id);
            $results = $repo->store($eventSchedule, $accessToken, $meta);
            foreach ($results as $result) {
                UserGoogleEventSchedule::create([
                    'user_id' => $eventSchedule->user->id,
                    'event_schedule_id' => $eventSchedule->id,
                    'google_calendar_id' => $result['google_calendar_id'],
                    'google_event_id' => $result['id'],
                    'google_meet_link' => $result['google_meet_link'],
                ]);
            }
        }

        return true;
    }
}
