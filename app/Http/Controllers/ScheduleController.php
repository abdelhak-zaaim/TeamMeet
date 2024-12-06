<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateScheduleRequest;
use App\Models\Event;
use App\Models\Schedule;
use App\Models\UserSchedule;
use App\Repositories\ScheduleRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ScheduleController extends AppBaseController
{
    /** @var ScheduleRepository */
    private $scheduleRepository;

    public function __construct(ScheduleRepository $scheduleRepo)
    {
        $this->scheduleRepository = $scheduleRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(): \Illuminate\View\View
    {
        $scheduleNameArr = $this->scheduleRepository->getScheduleNames();

        return view('schedules.index', compact('scheduleNameArr'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $input = $request->all();

        parse_str(html_entity_decode($input['form1']), $array);
        parse_str(html_entity_decode($input['form2']), $array2);
        $scheduleInput = $array;
        $scheduleSlotTime = $array2;

        if (count($scheduleSlotTime) > 0) {
            $data['schedule'] = $this->scheduleRepository->storeScheduleWithSlot($scheduleInput, $scheduleSlotTime);
            $data['event_id'] = $scheduleSlotTime['event_id'];
            $data['scheduleWithTime'] = true;
        } else {
            $validator = Validator::make($scheduleInput, [
                'schedule_name' => 'required',
                Rule::unique('schedules')
                    ->where('user_id', getLogInUserId()),
            ]);

            if ($validator->fails()) {
                return $this->sendError($validator->getMessageBag()->first());
            }

            $data['schedule'] = $this->scheduleRepository->store($scheduleInput);
            $data['scheduleWithTime'] = false;
        }

        if (empty($input['form2']) && $input['form2'] == null) {
            $defaultScheduleSlots = UserSchedule::where('event_id', null)->whereUserId(getLogInUserId())->whereScheduleId(defaultUserSchedule())->get();
            foreach ($defaultScheduleSlots as $defaultScheduleSlot) {
                UserSchedule::create([
                    'schedule_id' => $data['schedule']['id'],
                    'user_id' => $data['schedule']['user_id'],
                    'from_time' => $defaultScheduleSlot['from_time'],
                    'to_time' => $defaultScheduleSlot['to_time'],
                    'day_of_week' => $defaultScheduleSlot['day_of_week'],
                    'check_tab' => 0,
                    'check_default' => 0,
                ]);
            }
        }

        return $this->sendResponse($data, __('messages.schedule.schedule_created_successfully'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Schedule $schedule): JsonResponse
    {
        return $this->sendResponse($schedule, __('messages.success_message.schedule_retrieved'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateScheduleRequest $request, Schedule $schedule): JsonResponse
    {
        $userScheduleIds = Schedule::whereUserId(getLogInUserId())->pluck('id')->toArray();

        if (! in_array($schedule->id, $userScheduleIds)) {
            return $this->sendError(__('messages.schedule.this_schedule_can_not_be_updated'));
        }

        $input = $request->all();
        $schedule = $this->scheduleRepository->update($input, $schedule->id);
        $scheduleNameArr = $this->scheduleRepository->getScheduleNames();

        return $this->sendResponse($scheduleNameArr, __('messages.schedule.schedule_updated_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Schedule $schedule): JsonResponse
    {
        $userScheduleIds = Schedule::whereUserId(getLogInUserId())->pluck('id')->toArray();

        if (! in_array($schedule->id, $userScheduleIds)) {
            return $this->sendError(__('messages.schedule.this_schedule_can_not_be_deleted'));
        }

        $eventScheduleExist = Event::whereScheduleId($schedule->id)->exists();

        if ($eventScheduleExist) {
            return $this->sendError(__('messages.schedule.this_schedule_used_somewhere'));
        }

        $schedule = $schedule->delete();

        return $this->sendSuccess(__('messages.schedule.schedule_deleted_successfully'));
    }

    public function addScheduleTimeSlot(Request $request): JsonResponse
    {
        $input = $request->all();
        $result = $this->scheduleRepository->storeScheduleTimeSlot($input);

        if (! $result['success']) {
            return $this->sendError($result);
        }

        return $this->sendSuccess(__('messages.success_message.event_schedule_create'));
    }
}
