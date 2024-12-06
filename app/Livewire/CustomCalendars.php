<?php

namespace App\Livewire;

use App\Models\Event;
use App\Models\UserSchedule;
use App\Repositories\EventRepository;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\App;
use Livewire\Component;

class CustomCalendars extends Component
{
    public $date = '';

    public $slotDate = '';

    public $defaultSlotDate = '';

    public $event;

    /**
     * @var string[]
     */
    protected $listeners = [
        'refresh' => '$refresh',
        'changeMonth',
        'getSlotTime',
    ];

    public function render()
    {
        $date = ! empty($this->date) ? $this->date : Carbon::now();
        $periods = CarbonPeriod::create(Carbon::parse($date)->startOfMonth(), '1 day',
            Carbon::parse($date)->endOfMonth());
        $prevMonth = Carbon::parse($periods->first())->subMonth();
        $nextMonth = Carbon::parse($periods->first())->addMonth();
        $currentDate = Carbon::now()->format('Y-m-d');

        $slotDate = ! empty($this->slotDate) ? $this->slotDate : Carbon::now()->format('Y-m-d');
        $defaultDate = ! empty($this->defaultSlotDate) ? $this->defaultSlotDate : Carbon::now()->format('M d, Y');
        $month = Carbon::createFromFormat('M d, Y', $defaultDate);
        $eventSchedule = UserSchedule::whereEventId($this->event->id)->latest()->first();
        if (! empty($eventSchedule)) {
            $eventSchedules = UserSchedule::whereEventId($this->event->id)->where('check_tab', '=',
                $eventSchedule->check_tab)->get();
        } else {
            $eventSchedules = UserSchedule::whereEventId($this->event->id)->get();
        }

        $eventRepo = App::make(EventRepository::class);

        $slotPeriod = $eventRepo->getPeriod($this->event);
        $data = $eventRepo->getCustomCalendarSlots($this->event, $slotPeriod, $slotDate, $eventSchedules);

        if ($this->event->status == Event::ACTIVE) {
            $slotDaysArr = getSlotPeriodDates($slotPeriod, $eventSchedules);
        } else {
            $slotDaysArr = [];
        }

        return view('livewire.custom-calendars',
            compact('periods', 'prevMonth', 'nextMonth', 'currentDate', 'defaultDate', 'data',
                'slotDaysArr', 'month'));
    }

    public function changeMonth($date)
    {
        $this->date = $date['date'];
        $this->slotDate = Carbon::parse($this->date)->format('Y-m-d');
        $this->defaultSlotDate = Carbon::parse($this->date)->format('M d, Y');
    }

    public function getSlotTime($slotDate)
    {
        $this->slotDate = Carbon::parse($slotDate)->format('Y-m-d');
        $this->defaultSlotDate = Carbon::parse($slotDate)->format('M d, Y');
    }
}
