<?php

namespace App\Repositories;

use App\Models\Event;
use App\Models\Schedule;
use App\Models\UserSchedule;
use Carbon\Carbon;
use DateTime;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

/**
 * Class ScheduleRepository
 *
 * @version November 12, 2021, 10:43 am UTC
 */
class ScheduleRepository extends BaseRepository
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
        return Schedule::class;
    }

    /**
     * @return array|bool[]
     */
    public function store($scheduleInput)
    {
        $scheduleInput['user_id'] = getLogInUserId();
        $scheduleInput['status'] = ! empty($scheduleInput['status']) ? 1 : 0;
        $scheduleInput['is_custom'] = 1;

        $schedule = Schedule::create($scheduleInput);

        return $schedule;
    }

    /**
     * @return array|bool[]
     */
    public function storeScheduleWithSlot($scheduleInput, $scheduleSlotTime)
    {
        try {
            DB::beginTransaction();

            $scheduleInput['user_id'] = getLogInUserId();
            $scheduleInput['status'] = 1;

            $schedule = Schedule::create($scheduleInput);
            $event = Event::findOrFail($scheduleSlotTime['event_id']);
            $event->userSchedules()->whereNotNull('event_id')->where('check_tab', 1)->delete();
            //            $event->update(['schedule_id' => $schedule->id]);
            $result['success'] = true;

            if (! empty($scheduleSlotTime['event_id'])) {
                UserSchedule::where('event_id', $event->id)->delete();
            }

            if (! empty($scheduleSlotTime['checked_week_days']) && count($scheduleSlotTime['checked_week_days']) > 0) {
                foreach ($scheduleSlotTime['checked_week_days'] as $day) {
                    $result = $this->validateSlotTiming($scheduleSlotTime, $day);
                    if (! $result['success']) {
                        return $result;
                    }
                    $this->saveSlots($scheduleSlotTime, $day, $schedule->id, $scheduleSlotTime['event_id'],
                        $scheduleSlotTime['check_tab']);
                }
            }

            DB::commit();

            return $schedule;
        } catch (Exception $e) {
            DB::rollBack();
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    /**
     * @return mixed
     */
    public function update($input, $id)
    {
        $input['user_id'] = getLogInUserId();
        $input['status'] = ! empty($input['status']) ? 1 : 0;
        $schedule = Schedule::findOrFail($id);

        $schedule->update($input);

        return $schedule;
    }

    public function storeScheduleTimeSlot($input): array
    {
        $scheduleId = $input['schedule_id'];
        $existSchedule = UserSchedule::whereScheduleId($scheduleId)->first();

        if (! empty($existSchedule)) {
            $schedule = Schedule::find($scheduleId);
            $schedule->userSchedules()->whereNull('event_id')->delete();
        }

        $result['success'] = true;

        if (! empty($input['checked_week_days']) && count($input['checked_week_days']) > 0) {
            foreach ($input['checked_week_days'] as $day) {
                $result = $this->validateSlotTiming($input, $day);
                if (! $result['success']) {
                    return $result;
                }
                $this->saveSlots($input, $day, $scheduleId);
            }
        }

        return $result;
    }

    /**
     * @param  null  $eventId
     * @param  null  $checkTab
     */
    public function saveSlots($input, $day, $scheduleId, $eventId = null, $checkTab = 0): bool
    {
        $fromTimeArr = $input['from_time'][$day] ?? [];
        $toTimeArr = $input['to_time'][$day] ?? [];

        if (count($fromTimeArr) != 0 && count($toTimeArr) != 0) {
            foreach ($fromTimeArr as $key => $fromTime) {
                UserSchedule::create([
                    'user_id' => getLogInUserId(),
                    'schedule_id' => $scheduleId,
                    'event_id' => $eventId,
                    'day_of_week' => $day,
                    'check_tab' => $checkTab,
                    'from_time' => $fromTime,
                    'to_time' => $toTimeArr[$key],
                ]);
            }
        }

        return true;
    }

    public function validateSlotTiming($input, $day): array
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

    public function getScheduleNames(): array
    {
        $schedules = Schedule::loginUser()->whereIsCustom(true)->pluck('schedule_name', 'id')->toArray();

        return $schedules;
    }
}
