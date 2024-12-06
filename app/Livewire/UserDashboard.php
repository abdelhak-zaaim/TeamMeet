<?php

namespace App\Livewire;

use App\Models\Event;
use App\Models\EventSchedule;
use App\Models\Schedule;
use Carbon\Carbon;
use Livewire\Component;

class UserDashboard extends Component
{

    public $todayDate;
    public $todayScheduledEvents;
    public $upcomingScheduledEvents;
    public $activeEventsCount;
    public $activeSchedulesCount;
    public $loginUser;

    public function mount()
    {
        $todayDate = Carbon::now()->format('Y-m-d');
        $loginUser = getLogInUserId();

        $this->todayScheduledEvents = EventSchedule::with('event')
            ->where('status', '!=', EventSchedule::CANCELLED)->whereUserId($loginUser)
            ->whereScheduleDate($todayDate)->latest()->take(10)->get();
        $this->upcomingScheduledEvents = EventSchedule::with('event')->where('status', '!=', EventSchedule::CANCELLED)
            ->whereUserId($loginUser)->where('schedule_date', '>', $todayDate)->latest()->take(10)->get();
        $this->activeEventsCount = Event::whereUserId($loginUser)->whereStatus(true)->count();
        $this->activeSchedulesCount = Schedule::whereUserId($loginUser)->whereStatus(true)->count();
    }

    public function placeholder()
    {
        return view('livewire.user-dashboard-skeleton');
    }

    public function render()
    {
        return view('livewire.user-dashboard');
    }
}
