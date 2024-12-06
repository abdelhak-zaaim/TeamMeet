<?php

namespace App\Repositories;

use App\Models\Event;
use App\Models\EventGoogleCalendar;
use App\Models\GoogleCalendarIntegration;
use App\Models\GoogleCalendarList;
use App\Models\User;
use Carbon\Carbon;
use Google\Exception;
use Google_Client;
use Google_Service_Calendar;
use Google_Service_Calendar_Event;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

/**
 * Class GoogleCalendarRepository
 */
class GoogleCalendarRepository
{
    public $client;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $this->client = new Google_Client();
        // Set the application name, this is included in the User-Agent HTTP header.
        $this->client->setApplicationName(config('app.name'));
        // Set the authentication credentials we downloaded from Google.
        $this->client->setAuthConfig(resource_path(config('app.google_oauth_path')));
        // Setting offline here means we can pull data from the venue's calendar when they are not actively using the site.
        $this->client->setAccessType('offline');
        // This will include any other scopes (Google APIs) previously granted by the venue
        $this->client->setIncludeGrantedScopes(true);
        // Set this to force to consent form to display.
        $this->client->setApprovalPrompt('force');
        // Add the Google Calendar scope to the request.
        $this->client->addScope(Google_Service_Calendar::CALENDAR);
    }

    public function store($eventSchedule, $accessToken, $meta): array
    {
        $date = $eventSchedule['schedule_date'];
        $timezone = $eventSchedule->user->timezone;
        $timeZone = isset(User::TIME_ZONE_ARRAY[$timezone]) ? User::TIME_ZONE_ARRAY[$timezone] : null;
        $time = explode(' - ', $eventSchedule['slot_time']);
        $startTime = date('H:i', strtotime($time[0]));
        $endTime = date('H:i', strtotime($time[1]));
        $startDateTime = Carbon::parse($date.' '.$startTime, $timeZone)->toRfc3339String();
        $endDateTime = Carbon::parse($date.' '.$endTime, $timeZone)->toRfc3339String();

        $results = [];
        if ($accessToken) {
            $this->client->setAccessToken($accessToken);
            $service = new Google_Service_Calendar($this->client);

            foreach ($meta['lists'] as $calendarId) {
                $event = new Google_Service_Calendar_Event([
                    'summary' => $meta['name'],
                    'start' => ['dateTime' => $startDateTime],
                    'end' => ['dateTime' => $endDateTime],
                    'reminders' => ['useDefault' => true],
                    'description' => $meta['description'],
                ]);

                if ($eventSchedule->event->event_location == Event::GOOGLE_MEET) {
                    $data = $service->events->insert($calendarId, $event, ['conferenceDataVersion' => 1]);

                    $conference = new \Google_Service_Calendar_ConferenceData();
                    $conferenceRequest = new \Google_Service_Calendar_CreateConferenceRequest();
                    $conferenceRequest->setRequestId('randomString123');
                    $conference->setCreateRequest($conferenceRequest);
                    $data->setConferenceData($conference);

                    $data = $service->events->patch($calendarId, $data->id, $data, ['conferenceDataVersion' => 1]);

                    $data['google_meet_link'] = $data->hangoutLink;
                } else {
                    $data = $service->events->insert($calendarId, $event);
                }

                $data['google_calendar_id'] = $calendarId;
                $results[] = $data;
            }

            return $results;
        } else {
            return $results;
        }
    }

    public function syncCalendarList($user): array
    {
        $this->getAccessToken($user->id);

        $gcHelper = new Google_Service_Calendar($this->client);
        // Use the Google Client calendar service. This gives us methods for interacting
        // with the Google Calendar API
        $calendarList = $gcHelper->calendarList->listCalendarList();

        $googleCalendarList = [];

        $existingCalendars = GoogleCalendarList::whereUserId(getLogInUserId())
            ->pluck('google_calendar_id', 'google_calendar_id')
            ->toArray();

        foreach ($calendarList->getItems() as $calendarListEntry) {
            if ($calendarListEntry->accessRole == 'owner') {
                $exists = GoogleCalendarList::whereUserId(getLogInUserId())
                    ->where('google_calendar_id', $calendarListEntry['id'])
                    ->first();

                unset($existingCalendars[$calendarListEntry['id']]);

                if (! $exists) {
                    $googleCalendarList[] = GoogleCalendarList::create([
                        'user_id' => getLogInUserId(),
                        'calendar_name' => $calendarListEntry['summary'],
                        'google_calendar_id' => $calendarListEntry['id'],
                        'meta' => json_encode($calendarListEntry),
                    ]);
                }
            }
        }

        EventGoogleCalendar::whereIn('google_calendar_id', $existingCalendars)->delete();
        GoogleCalendarList::whereIn('google_calendar_id', $existingCalendars)->delete();

        return $googleCalendarList;
    }

    public function getAccessToken($userId): mixed
    {
        $user = User::with('gCredentials')->find($userId);
        $accessToken = json_decode($user->gCredentials->meta, true);

        if (is_array($accessToken) && count($accessToken) == 0) {
            throw new UnprocessableEntityHttpException('Please disconnect and reconnect your google calendar');
        } elseif ($accessToken == null) {
            throw new UnprocessableEntityHttpException('Please disconnect and reconnect your google calendar');
        }

        if (empty($accessToken['access_token'])) {
            throw new UnprocessableEntityHttpException('Please disconnect and reconnect your google calendar');
        }

        try {
            // Refresh the token if it's expired.
            $this->client->setAccessToken($accessToken);

            if ($this->client->isAccessTokenExpired()) {
                Log::info('expired');

                if(isset($accessToken['refresh_token']))
                {
                    $accessToken = $this->client->fetchAccessTokenWithRefreshToken($accessToken['refresh_token']);

                }
                if (is_array($accessToken) && count($accessToken) == 0) {
                    throw new UnprocessableEntityHttpException('Please disconnect and reconnect your google calendar');
                } elseif ($accessToken == null) {
                    throw new UnprocessableEntityHttpException('Please disconnect and reconnect your google calendar');
                }

                if (empty($accessToken['access_token'])) {
                    throw new UnprocessableEntityHttpException('Please disconnect and reconnect your google calendar');
                }

                $calendarRecord = GoogleCalendarIntegration::whereUserId($user->id)->first();
                $calendarRecord->update([
                    'access_token' => $accessToken['access_token'],
                    'meta' => json_encode($accessToken),
                    'last_used_at' => Carbon::now(),
                ]);
            }
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());

            throw new UnprocessableEntityHttpException($exception->getMessage());
        }

        return $accessToken['access_token'];
    }

    /**
     * @return RedirectResponse|void
     */
    public function destroy($eventSchedules)
    {
        foreach ($eventSchedules as $eventSchedule) {
            $accessToken = $this->getAccessToken($eventSchedule->user->id);

            if ($accessToken) {
                $this->client->setAccessToken($accessToken);
                $service = new Google_Service_Calendar($this->client);

                $service->events->delete($eventSchedule->google_calendar_id, $eventSchedule->google_event_id);
            } else {
                return redirect()->route('oauthCallback');
            }
        }
    }
}
