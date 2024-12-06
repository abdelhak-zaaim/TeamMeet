<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Models\Event;
use App\Models\EventSchedule;
use App\Models\Schedule;
use App\Models\User;
use App\Models\UserSchedule;
use App\Models\UserSetting;
use App\Repositories\EventRepository;
use Carbon\Carbon;
use Exception;
use Flash;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Crypt;
use App\Models\Brand;
use App\Models\Faq;
use App\Models\FrontTestimonial;
use App\Models\MainReason;
use App\Models\Service;

class EventController extends AppBaseController
{
    /** @var EventRepository */
    private $eventRepository;

    public function __construct(EventRepository $eventRepo)
    {
        $this->eventRepository = $eventRepo;
    }

    /**
     * Display a listing of the Event.
     *
     * @return Application|Factory|View
     */
    public function index(): \Illuminate\View\View
    {
        return view('events.index');
    }

    /**
     * Show the form for creating a new Event.
     *
     * @return Application|Factory|View
     */
    public function create(): \Illuminate\View\View
    {
        $locationArr = Event::LOCATION_ARRAY;

        return view('events.create', compact('locationArr'));
    }

    /**
     * Store a newly created Event in storage.
     *
     * @return Application|Redirector|RedirectResponse
     */
    public function store(CreateEventRequest $request): RedirectResponse
    {
        $input = $request->all();
        if (assignPlanFeatures(getLogInUserId())->events <= getActiveEventsCount() && assignPlanFeatures(getLogInUserId())->events != Event::UNLIMITED_EVENT) {
            Flash::error(__('messages.success_message.upgrade_plan'));

            return redirect()->back();
        }

        $event = $this->eventRepository->store($input);

        Flash::success(__('messages.success_message.event_created'));

        return redirect(route('events.edit', $event->id));
    }

    /**
     * @return Application|Factory|View|RedirectResponse
     */
    public function show(Event $event)
    {
        if (getLogInUserId() !== $event->user_id) {
            return redirect()->back();
        }

        $statusArr = EventSchedule::STATUS;

        return view('events.show', compact('event', 'statusArr'));
    }

    /**
     * Show the form for editing the specified Event.
     *
     * @return Application|Factory|View|RedirectResponse
     */
    public function edit(Event $event)
    {
        if (getLogInUserId() !== $event->user_id) {
            return redirect()->back();
        }

        $locationArr = Event::LOCATION_ARRAY;
        $checkSelectedTab = null;
        if (! empty($event->schedule_id)) {
            $existingScheduleWeekDays = UserSchedule::user()->whereScheduleId($event->schedule_id)
                ->whereEventId($event->id)
                ->whereCheckTab(UserSchedule::EXISTING_SCHEDULE)
                ->orWhere('check_default', true)
                ->get();
            $userEventSchedule = UserSchedule::user()->whereEventId($event->id)->latest()->first();

            if (! empty($userEventSchedule)) {
                $checkSelectedTab = $userEventSchedule->check_tab;
            } else {
                $checkSelectedTab = UserSchedule::EXISTING_SCHEDULE;
            }

            $userSchedule = UserSchedule::user()->whereEventId($event->id)
                ->whereCheckTab(UserSchedule::CUSTOM_SCHEDULE)->whereCheckDefault(false)->latest()->first();

            if (! empty($userSchedule->event_id) && $userSchedule->check_tab) {
                $customScheduleWeekDays = UserSchedule::user()->whereEventId($event->id)
                    ->whereCheckTab($userSchedule->check_tab)->get();
            } else {
                $customScheduleWeekDays = UserSchedule::user()->whereScheduleId(defaultUserSchedule())->whereNull('event_id')->get();
            }
        } else {
            $customScheduleWeekDays = UserSchedule::user()->whereScheduleId(defaultUserSchedule())->whereNull('event_id')->get();
            $existingScheduleWeekDays = $customScheduleWeekDays;
        }

        $scheduleIds = UserSchedule::whereEventId($event->id)
            ->where('schedule_id', '!=', defaultUserSchedule())
            ->whereCheckTab(UserSchedule::EXISTING_SCHEDULE)
            ->pluck('schedule_id')->toArray();
        $scheduleIds = array_unique($scheduleIds);

        $defaultScheduleIds = Schedule::loginUser()->whereStatus(true)->where('is_custom',
            true)->pluck('id')->toArray();

        $defaultScheduleIds = array_merge($defaultScheduleIds, $scheduleIds);

        $scheduleNameArr = Schedule::loginUser()->whereIn('id',
            $defaultScheduleIds)->whereStatus(true)->pluck('schedule_name', 'id')->toArray();

        $defaultScheduleWeekDays = defaultScheduleWeekDays();

        return view('events.edit',
            compact('event', 'locationArr', 'scheduleNameArr', 'existingScheduleWeekDays', 'customScheduleWeekDays',
                'defaultScheduleWeekDays', 'checkSelectedTab'));
    }

    /**
     * Update the specified Event in storage.
     *
     * @return Application|Redirector|RedirectResponse
     */
    public function update(UpdateEventRequest $request, Event $event): RedirectResponse
    {
        $event = $this->eventRepository->update($request->all(), $event->id);

        Flash::success(__('messages.success_message.event_update'));

        return redirect(route('events.index'));
    }

    public function changeStatus($id): JsonResponse
    {
        $event = Event::findOrFail($id);

        $event->update(['status' => ! $event->status]);

        return $this->sendSuccess(__('messages.success_message.event_status_change'));
    }

    public function getSlotByGap(Request $request): JsonResponse
    {
        $day = $request->get('day');
        $schedule = UserSchedule::whereDayOfWeek($day)->first();
        $timeArr = getSlotByGap($schedule->from_time, $schedule->to_time);
        $html = view('events.slot', ['timeArr' => $timeArr, 'day' => $day])->render();

        return $this->sendResponse($html, __('messages.retrieved_successfully'));
    }

    public function addEventSchedule(Request $request): JsonResponse
    {
        $request->validate([
            'schedule_days' => 'integer|min:1|max:60',
        ]);

        $input = $request->all();
        $timeZone = isset(getLoginUser()->timezone) ?
            User::TIME_ZONE_ARRAY[getLoginUser()->timezone] : User::TIME_ZONE_ARRAY[getTimeZone()];
        date_default_timezone_set($timeZone);

        if (isset($input['within_date_range']) && isset($input['checked_week_days'])) {
            $date = explode(' - ', $input['within_date_range']);
            if ($date[1] == Carbon::now()->format('m/d/Y')) {
                $dayOfWeek = Carbon::createFromFormat('m/d/Y', $date[1])->dayOfWeek;
                if (! in_array($dayOfWeek, $input['checked_week_days']) || ! in_array($dayOfWeek,
                    array_keys($input['to_time']))) {
                    return $this->sendError(__('messages.not_be_created_checked_day'));
                }
                foreach ($input['to_time'] as $key => $value) {
                    if ($key == $dayOfWeek) {
                        if (strtotime($value[0]) < strtotime(date(getUserSettingTimeFormat(getLogInUserId())))) {
                            return $this->sendError(__('messages.not_be_created_time_has_passed'));
                        }
                    }
                }
            }
        }

        $result = $this->eventRepository->storeEventSchedule($input);

        if (! $result['success']) {
            return $this->sendError($result);
        }

        return $this->sendSuccess(__('messages.success_message.event_schedule_create'));
    }

    public function getTimeBySchedule(Request $request): JsonResponse
    {
        $scheduleId = $request->get('schedule_id');
        $eventId = $request->get('event_id');
        $userDefaultSchedule = Schedule::loginUser()->whereId($scheduleId)->whereIsDefault(true)->exists();

        if ($userDefaultSchedule) {
            $existingScheduleWeekDays = UserSchedule::user()->whereScheduleId($scheduleId)->whereNull('event_id')->get();
        } else {
            $exist = UserSchedule::user()->whereScheduleId($scheduleId)->where('event_id',
                $eventId)->where('check_tab', '=', UserSchedule::CUSTOM_SCHEDULE)->first();
            if (! empty($eventId) && ! empty($exist)) {
                $existingScheduleWeekDays = UserSchedule::user()->whereScheduleId($scheduleId)->where('event_id',
                    $eventId)->where('check_tab',
                        '=', UserSchedule::CUSTOM_SCHEDULE)->get();
            } else {
                $existingScheduleWeekDays = UserSchedule::user()->whereScheduleId($scheduleId)->whereNull('event_id')->where('check_tab',
                    '=', UserSchedule::EXISTING_SCHEDULE)->get();
            }
        }

        $html = view('events.existing_schedule', ['existingScheduleWeekDays' => $existingScheduleWeekDays])->render();

        return $this->sendResponse($html, __('messages.retrieved_successfully'));
    }

    /**
     * @return Application|Factory|View
     *
     * @throws Exception
     */
    public function slotsCalendar(Request $request, $domain_url, $event_link)
    {
        $event = getFirstEventAsPerLink($event_link);
        if (! $event) {
            return abort(404);
        }

        if (getCalendarView($event->user->id, 'calendar_view') == 2) {
            return view('custom_livewire_calendar.custom_calendar', compact('event'));
        }

        $eventSchedule = UserSchedule::whereEventId($event->id)->latest()->first();
        if (! empty($eventSchedule)) {
            $eventSchedules = UserSchedule::whereEventId($event->id)->where('check_tab', '=',
                $eventSchedule->check_tab)->get();
        } else {
            $eventSchedules = UserSchedule::whereEventId($event->id)->get();
        }

        if (! empty($request->get('month')) || ! empty($request->get('year'))) {
            $slotMonth = ! empty($request->get('month')) ? Carbon::parse($request->get('month'))->month : Carbon::now()->month;
            $slotYear = ! empty($request->get('year')) ? $request->get('year') : Carbon::now()->year;
            $period = $this->eventRepository->getPeriod($event);
            $data = $this->eventRepository->getSlotDay($event, $period, $eventSchedules);
            $month = $slotMonth - 1;

            return view('events.slots_calendar', compact('event', 'data', 'month', 'slotYear'));
        } else {
            $period = $this->eventRepository->getPeriod($event);
            $data = $this->eventRepository->getSlotDay($event, $period, $eventSchedules);
            $month = Carbon::now()->month - 1;
            $slotYear = Carbon::now()->year;

            return view('events.slots_calendar', compact('event', 'data', 'month', 'slotYear'));
        }
    }

    /**
     * @return Application|Factory|View
     */
    public function slotDetail(Request $request, $domain_url, $event_link, $schedule_time): \Illuminate\View\View
    {
        $scheduleDate = $schedule_time;
        $scheduleTime = $request->get('time');
        $orgScheduleTime = $request->get('originalTime');
        $paymentMethod = EventSchedule::PAYMENT_METHOD;
        $event = getFirstEventAsPerLink($event_link);
        $userId = $event->user_id;
        $paymentType = UserSetting::whereUserId($userId)->pluck('value', 'key')->toArray();

        if (isset($paymentType['stripe_enable']) && $paymentType['stripe_enable'] == 0) {
            $paymentMethod = Arr::except($paymentMethod, [EventSchedule::STRIPE]);
        }
        if (isset($paymentType['paypal_enable']) && $paymentType['paypal_enable'] == 0) {
            $paymentMethod = Arr::except($paymentMethod, EventSchedule::PAYPAL);
        }
        if (isset($paymentType['paystack_enable']) && $paymentType['paystack_enable'] == 0) {
            $paymentMethod = Arr::except($paymentMethod, EventSchedule::PAYSTACK);
        }
        if (isset($paymentType['razorpay_enable']) && $paymentType['razorpay_enable'] == 0) {
            $paymentMethod = Arr::except($paymentMethod, EventSchedule::RAZORPAY);
        }

        return view('events.slot_detail', compact('event', 'scheduleDate', 'scheduleTime', 'paymentMethod', 'paymentType', 'orgScheduleTime'));
    }




    public function Allevent(Request $request, $domain_url, $user_id)
    {
        // $user_id = Crypt::decryptString($user_id);
        $data['frontTestimonials'] = FrontTestimonial::with('media')->get();
        $frontCMSSettings = getFrontCMSSetting();
        $mainReasons = MainReason::toBase()->pluck('value', 'key')->toArray();
        $data['brands'] = Brand::with('media')->latest()->get()->take(6);
        $data['services'] = Service::with('media')->pluck('value', 'key')->toArray();
        $data['registeredUsersCount'] = getRegisteredUsersCount();
        $data['eventsCreatedCount'] = getEventsCreatedCount();
        $data['scheduledEventsCount'] = getScheduledEventsCount();
        return view('events.user_all_event',compact('user_id','data', 'frontCMSSettings', 'mainReasons'));
    }
}
