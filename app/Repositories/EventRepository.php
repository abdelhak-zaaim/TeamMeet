<?php

namespace App\Repositories;

use App\Models\Event;
use App\Models\EventSchedule;
use App\Models\User;
use App\Models\UserSchedule;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use DateTime;
use Exception;
use Illuminate\Support\Arr;

/**
 * Class EventRepository
 *
 * @version October 27, 2021, 6:47 am UTC
 */
class EventRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
    ];

    /**
     * Return searchable fields
     */
    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Event::class;
    }

    public function store($input)
    {
        $input['user_id'] = getLogInUserId();
        $event = Event::create($input);

        return $event;
    }

    public function update($input, $id)
    {
        $event = Event::find($id);
        $event->update($input);

        return $event;
    }

    public function storeEventSchedule($input): array
    {
        $eventId = $input['event_id'];
        $withinDateRange = ! empty($input['within_date_range']) ? explode('-', $input['within_date_range']) : null;
        $event = Event::find($eventId);
        $timeZone = $event->user->update(['timezone' => $input['timezone']]);

        $event->update([
            'schedule_id' => $input['schedule_name'],
            'gap_slot' => ! empty($input['gap_slot']) ? $input['gap_slot'] : null,
            'slot_time' => $input['slot_time'],
            'date_range' => $input['date_range'] == 1 ? 1 : 0,
            'schedule_days' => ! empty($input['schedule_days']) ? $input['schedule_days'] : '60',
            'schedule_from' => ! empty($withinDateRange[0]) ? $withinDateRange[0] : $withinDateRange,
            'schedule_to' => ! empty($withinDateRange[1]) ? $withinDateRange[1] : $withinDateRange,
        ]);

        $timeZoneName = isset(getLoginUser()->timezone) ?
            User::TIME_ZONE_ARRAY[getLoginUser()->timezone] : User::TIME_ZONE_ARRAY[getTimeZone()];
        date_default_timezone_set($timeZoneName);

        $result['success'] = true;

        if ($input['check_tab'] == UserSchedule::EXISTING_SCHEDULE) {
            $record = $event->userSchedules()->whereNotNull('event_id')->where('check_tab', 0)->first();
            $checkDefault = ! empty($record->checkDefault) ? $record->checkDefault : false;
            $exist = UserSchedule::user()->whereScheduleId($input['schedule_name'])->where('check_tab', '=',
                UserSchedule::CUSTOM_SCHEDULE)->first();

            if (! empty($input['event_id']) && ! empty($exist)) {
                $event->userSchedules()->whereNotNull('event_id')->where('check_tab', 0)->delete();
                $userSchedules = UserSchedule::whereScheduleId($input['schedule_name'])->where('event_id',
                    $input['event_id'])->where('check_tab', UserSchedule::CUSTOM_SCHEDULE)->get();
            } else {
                $event->userSchedules()->whereNotNull('event_id')->where('check_tab', 0)->delete();
                $userSchedules = UserSchedule::whereScheduleId($input['schedule_name'])->whereNull('event_id')->where('check_tab',
                    UserSchedule::EXISTING_SCHEDULE)->get();
            }

            if (count($userSchedules) > 0) {
                if (defaultUserSchedule() != $input['schedule_name']) {
                    foreach ($userSchedules as $userSchedule) {
                        UserSchedule::create([
                            'event_id' => $input['event_id'],
                            'user_id' => $event->user->id,
                            'schedule_id' => $userSchedule->schedule_id,
                            'day_of_week' => $userSchedule->day_of_week,
                            'from_time' => $userSchedule->from_time,
                            'to_time' => $userSchedule->to_time,
                            'check_default' => 1,
                        ]);
                    }
                }
            }

            if (defaultUserSchedule() == $input['schedule_name'] && ! $checkDefault) {
                $defaultUserSchedules = UserSchedule::whereScheduleId($input['schedule_name'])->whereNull('event_id')->get();

                if (count($defaultUserSchedules) > 0) {
                    foreach ($defaultUserSchedules as $defaultUserSchedule) {
                        UserSchedule::create([
                            'event_id' => $input['event_id'],
                            'user_id' => $event->user->id,
                            'schedule_id' => $defaultUserSchedule->schedule_id,
                            'day_of_week' => $defaultUserSchedule->day_of_week,
                            'from_time' => $defaultUserSchedule->from_time,
                            'to_time' => $defaultUserSchedule->to_time,
                            'check_tab' => 0,
                        ]);
                    }
                }
            }
        } else {
            $event->userSchedules()->whereNotNull('event_id')->where('check_tab', 1)->delete();

            if (! empty($input['checked_week_days']) && count($input['checked_week_days']) > 0) {
                foreach ($input['checked_week_days'] as $day) {
                    $result = $this->validateSlotTiming($input, $day);
                    if (! $result['success']) {
                        return $result;
                    }
                    $this->saveSlots($input, $day, $eventId);
                }
            }
        }

        return $result;
    }

    public function saveSlots($input, $day, $eventId): bool
    {
        $scheduleId = $input['schedule_name'];
        $fromTimeArr = $input['from_time'][$day] ?? [];
        $toTimeArr = $input['to_time'][$day] ?? [];

        if (count($fromTimeArr) != 0 && count($toTimeArr) != 0) {
            foreach ($fromTimeArr as $key => $fromTime) {
                UserSchedule::create([
                    'event_id' => $eventId,
                    'user_id' => getLogInUserId(),
                    'schedule_id' => $scheduleId,
                    'day_of_week' => $day,
                    'check_tab' => $input['check_tab'],
                    'from_time' => $fromTime,
                    'to_time' => $toTimeArr[$key],
                ]);
            }
        }

        return true;
    }

    /**
     * @return array|bool[]
     */
    public function validateSlotTiming($input, $day)
    {
        $fromTimeArr = $input['from_time'][$day] ?? [];
        $toTimeArr = $input['to_time'][$day] ?? [];

        foreach ($fromTimeArr as $key => $startTime) {
            $slotStartTime = Carbon::instance(DateTime::createFromFormat(getUserSettingTimeFormat(getLogInUserId()), $startTime));
            $tempArr = Arr::except($fromTimeArr, [$key]);
            foreach ($tempArr as $tempKey => $tempStartTime) {
                $start = Carbon::instance(DateTime::createFromFormat(getUserSettingTimeFormat(getLogInUserId()), $tempStartTime));
                $end = Carbon::instance(DateTime::createFromFormat(getUserSettingTimeFormat(getLogInUserId()), $toTimeArr[$tempKey]));
                if ($slotStartTime->isBetween($start, $end)) {
                    return ['day' => $day, 'startTime' => $startTime, 'success' => false, 'key' => $key];
                }
            }
        }

        return ['success' => true];
    }

    /**
     * @throws Exception
     */
    public function getSlotDay($event, $period, $eventSchedules): ?array
    {
        if ($event->status == Event::DE_ACTIVE) {
            return null;
        }

        $user = getUserRecord($event->user_id);
        $defaultTimezone = getTimeZone();
        $timeZoneName = isset($user->timezone) ?
            User::TIME_ZONE_ARRAY[$user->timezone] : User::TIME_ZONE_ARRAY[$defaultTimezone];
        date_default_timezone_set($timeZoneName);
        $days = [];

        foreach ($period as $date) {
            if ($date->format('l') == 'Monday') {
                $days[UserSchedule::Mon][] = $date->format('Y/m/d');
            } elseif ($date->format('l') == 'Tuesday') {
                $days[UserSchedule::Tue][] = $date->format('Y/m/d');
            } elseif ($date->format('l') == 'Wednesday') {
                $days[UserSchedule::Wed][] = $date->format('Y/m/d');
            } elseif ($date->format('l') == 'Thursday') {
                $days[UserSchedule::Thu][] = $date->format('Y/m/d');
            } elseif ($date->format('l') == 'Friday') {
                $days[UserSchedule::Fri][] = $date->format('Y/m/d');
            } elseif ($date->format('l') == 'Saturday') {
                $days[UserSchedule::Sat][] = $date->format('Y/m/d');
            } elseif ($date->format('l') == 'Sunday') {
                $days[UserSchedule::Sun][] = $date->format('Y/m/d');
            }
        }

        $data = [];
        $bookEventSchedules = EventSchedule::whereEventId($event->id)->where('status', '!=',
            EventSchedule::CANCELLED)->get(['slot_time', 'schedule_date'])->groupBy(function ($data) {
                return Carbon::parse($data->schedule_date)->format('Y/m/d');
            })->toArray();

        foreach ($eventSchedules as $eventSchedule) {
            if (isset($days[$eventSchedule->day_of_week])) {
                foreach ($days[$eventSchedule->day_of_week] as $day) {
                    $bookedSlots = ! empty($bookEventSchedules[$day]) ? $this->getSlots($bookEventSchedules[$day]) : [];
                    $slots = $this->getEventScheduleSlot($event, $eventSchedule->from_time, $eventSchedule->to_time);
                    $slots = array_diff($slots, $bookedSlots);

                    foreach ($slots as $key => $slot) {
                        $time = explode(' -', $slot);
                        $slotStartTime = $time[0];

                        $isTodayDate = Carbon::now(User::TIME_ZONE_ARRAY[$defaultTimezone])->format('Y/m/d') == $day;

                        $convertedSt = Carbon::parse('2023-01-01 '.$slotStartTime, $timeZoneName);
                        $convertedSt->setTimezone(User::TIME_ZONE_ARRAY[$defaultTimezone]);
                        $convertedSt = $convertedSt->format(getUserSettingTimeFormat($user->id));

                        $convertedEt = Carbon::parse('2023-01-01 '.$time[1], $timeZoneName);
                        $convertedEt->setTimezone(User::TIME_ZONE_ARRAY[$defaultTimezone]);
                        $convertedEt = $convertedEt->format(getUserSettingTimeFormat($user->id));

                        if (! $isTodayDate || (strtotime($slotStartTime) > strtotime(date(getUserSettingTimeFormat($user->id))))) {
                            $data[] = [
                                'id' => $key + 1,
                                'name' => $convertedSt. ' - ' .$convertedEt,
                                'date' => $day,
                                'description' => $slot . " ($timeZoneName)",
                                'originalTime' => $slot,
                                'type' => 'event',
                                'color' => '#63d867',
                            ];
                        }

                    }
                }
            }
        }
        return $data;
    }

    public function getSlots($bookedSlots): array
    {
        $bookedSlotsArr = [];

        foreach ($bookedSlots as $slots) {
            $bookedSlotsArr[] = $slots['slot_time'];
        }

        return $bookedSlotsArr;
    }

    /**
     * @throws Exception
     */
    public function getCustomCalendarSlots($event, $period, $slotDate, $eventSchedules): ?array
    {
        $slotDate = Carbon::parse($slotDate)->format('Y/m/d');
        $user = getUserRecord($event->user_id);
        $defaultTimezone = getTimeZone();
        $timeZoneName = isset($user->timezone) ?
            User::TIME_ZONE_ARRAY[$user->timezone] : User::TIME_ZONE_ARRAY[$defaultTimezone];
        date_default_timezone_set($timeZoneName);

        if ($event->status == Event::DE_ACTIVE) {
            return null;
        }

        $days = [];
        foreach ($period as $date) {
            if ($date->format('l') == 'Monday') {
                $days[UserSchedule::Mon][] = $date->format('Y/m/d');
            } elseif ($date->format('l') == 'Tuesday') {
                $days[UserSchedule::Tue][] = $date->format('Y/m/d');
            } elseif ($date->format('l') == 'Wednesday') {
                $days[UserSchedule::Wed][] = $date->format('Y/m/d');
            } elseif ($date->format('l') == 'Thursday') {
                $days[UserSchedule::Thu][] = $date->format('Y/m/d');
            } elseif ($date->format('l') == 'Friday') {
                $days[UserSchedule::Fri][] = $date->format('Y/m/d');
            } elseif ($date->format('l') == 'Saturday') {
                $days[UserSchedule::Sat][] = $date->format('Y/m/d');
            } elseif ($date->format('l') == 'Sunday') {
                $days[UserSchedule::Sun][] = $date->format('Y/m/d');
            }
        }

        $data = [];
        $bookEventSchedules = EventSchedule::whereEventId($event->id)->where('status', '!=',
            EventSchedule::CANCELLED)->get(['slot_time', 'schedule_date'])->groupBy(function ($data) {
                return Carbon::parse($data->schedule_date)->format('Y/m/d');
            })->toArray();

        foreach ($eventSchedules as $eventSchedule) {
            if (isset($days[$eventSchedule->day_of_week])) {
                foreach ($days[$eventSchedule->day_of_week] as $day) {
                    $day = Carbon::parse($day)->format('Y/m/d');
                    if ($slotDate == $day) {
                        $bookedSlots = ! empty($bookEventSchedules[$day]) ? $this->getSlots($bookEventSchedules[$day]) : [];
                        $slots = $this->getEventScheduleSlot($event, $eventSchedule->from_time,
                            $eventSchedule->to_time);
                        $slots = array_diff($slots, $bookedSlots);

                        foreach ($slots as $key => $slot) {
                            $time = explode(' -', $slot);
                            $slotStartTime = $time[0];

                            $isTodayDate = Carbon::now(User::TIME_ZONE_ARRAY[$defaultTimezone])->format('Y/m/d') == $day;

                            $convertedSt = Carbon::parse('2023-01-01 '.$slotStartTime, $timeZoneName);
                            $convertedSt->tz(User::TIME_ZONE_ARRAY[$defaultTimezone]);
                            $convertedSt = $convertedSt->format(getUserSettingTimeFormat($user->id));

                            $convertedEt = Carbon::parse('2023-01-01 '.$time[1], $timeZoneName);
                            $convertedEt->tz(User::TIME_ZONE_ARRAY[$defaultTimezone]);
                            $convertedEt = $convertedEt->format(getUserSettingTimeFormat($user->id));

                            if (! $isTodayDate || (strtotime($slotStartTime) > strtotime(date(getUserSettingTimeFormat($user->id))))) {
                                $data[] = [
                                    'id' => $key + 1,
                                    'time' => $convertedSt.' - '.$convertedEt,
                                    'timeWithTimezone' => $slot.' ('.$timeZoneName.')',
                                    'timezone' => $timeZoneName,
                                    'originalTime' => $slot,
                                    'date' => Carbon::parse($day)->format('Y-m-d'),
                                    'eventSchedule' => $eventSchedule,
                                ];
                            }
                        }
                    }
                }
            }
        }

        return $data;
    }

    /**
     * @throws Exception
     */
    public function getEventScheduleSlot($event, $fromTime, $toTime): array
    {
        $bookingSlot = [];

        // convert 12 hours to 24 hours
        $startTime = date('H:i', strtotime($fromTime));
        $endTime = date('H:i', strtotime($toTime));
        $slots = $this->getTimeSlot($event->slot_time, $startTime, $endTime);
        $gap = $event->gap_slot;

        $lastSlot = null;
        foreach ($slots as $key => $slot) {
            $key--;
            if ($key != 0) {
                if (! empty($gap)) {
                    $slotStartTime = date(getUserSettingTimeFormat($event->user->id), strtotime('+'.$gap * $key.'minutes', strtotime($slot[0])));
                    $slotEndTime = date(getUserSettingTimeFormat($event->user->id), strtotime('+'.$gap * $key.'minutes', strtotime($slot[1])));
                } else {
                    $slotStartTime = date(getUserSettingTimeFormat($event->user->id), strtotime($slot[0]));
                    $slotEndTime = date(getUserSettingTimeFormat($event->user->id), strtotime($slot[1]));
                }

                if (strtotime($slotEndTime) > strtotime($endTime)) {
                    break;
                }

                if (strtotime($slotStartTime) < strtotime($slotEndTime)) {
                    $startTimeOrg = Carbon::parse(date(getUserSettingTimeFormat($event->user->id), strtotime($slotStartTime)));
                    $slotStartTimeCarbon = Carbon::parse(date(getUserSettingTimeFormat($event->user->id), strtotime($startTime)));
                    $slotEndTimeCarbon = Carbon::parse(date(getUserSettingTimeFormat($event->user->id), strtotime($endTime)));
                    if (! $startTimeOrg->between($slotStartTimeCarbon, $slotEndTimeCarbon)) {
                        break;
                    }

                    if (empty($lastSlot) || strtotime($slotStartTime) > strtotime($lastSlot)) {
                        $lastSlot = $slotStartTime;

                        $bookingSlot[] = $slotStartTime.' - '.$slotEndTime;
                    }
                }
            } else {
                $bookingSlot[] = date(getUserSettingTimeFormat($event->user->id), strtotime($slot[0])).' - '.date(getUserSettingTimeFormat($event->user->id), strtotime($slot[1]));
            }
        }

        return $bookingSlot;
    }

    /**
     * @throws Exception
     */
    public function getTimeSlot($interval, $from_time, $to_time): array
    {
        $start = new DateTime($from_time);
        $end = new DateTime($to_time);
        $carbonStart = Carbon::createFromFormat('H:i', $from_time);
        $carbonEnd = Carbon::createFromFormat('H:i', $to_time);
        $startTime = $start->format('H:i');
        $endTime = $originalEndTime = $end->format('H:i');
        $i = 0;
        $time = [];

        while (strtotime($startTime) <= strtotime($endTime)) {
            $start = $startTime;
            $end = date('H:i', strtotime('+'.$interval.' minutes', strtotime($startTime)));
            $startTime = date('H:i', strtotime('+'.$interval.' minutes', strtotime($startTime)));

            if (! Carbon::createFromFormat('H:i', $start)->isBetween($carbonStart,
                $carbonEnd) || ! Carbon::createFromFormat('H:i', $end)->isBetween($carbonStart, $carbonEnd)) {
                break;
            }
            $i++;

            if (strtotime($startTime) <= strtotime($endTime)) {
                $time[$i][] = $start;
                $time[$i][] = $end;
            }

            if (strtotime($startTime) >= strtotime($originalEndTime)) {
                break;
            }

            if (strtotime($start) >= strtotime($end)) {
                break;
            }
        }

        return $time;
    }

    public function getPeriod($event): CarbonPeriod
    {
        if ($event->date_range == false) {
            $slotStartMonth = Carbon::parse($event->schedule_from)->month;
            $slotStartYear = Carbon::parse($event->schedule_from)->year;
            $slotEndMonth = Carbon::parse($event->schedule_to)->month;
            $slotEndYear = Carbon::parse($event->schedule_to)->year;
            $slotStartDate = Carbon::parse($event->schedule_from)->day;
            $slotEndDate = Carbon::parse($event->schedule_to)->day;
        } else {
            $slotStartMonth = Carbon::now()->month;
            $slotStartYear = Carbon::now()->year;
            $slotStartDate = Carbon::now()->day;
            $slotEndMonth = Carbon::now()->addDays($event->schedule_days)->month;
            $slotEndYear = Carbon::now()->addDays($event->schedule_days)->year;
            $slotEndDate = Carbon::now()->addDays($event->schedule_days)->day;
        }

        $startOfMonth = Carbon::create($slotStartYear, $slotStartMonth, $slotStartDate);
        $endOfMonth = Carbon::create($slotEndYear, $slotEndMonth, $slotEndDate);
        $period = CarbonPeriod::create($startOfMonth, $endOfMonth);

        return $period;
    }
}
