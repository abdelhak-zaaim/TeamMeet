<?php

namespace App\Livewire;

use App\Models\Event;
use App\Models\EventSchedule;
use App\Models\User;
use Livewire\Component;

class Dashboard extends Component
{


    public $totalUsers;
    public $totalScheduledEvents;
    public $totalActiveEvents;

    public function mount()
    {
        $this->totalUsers = User::role('user')->count();
        $this->totalScheduledEvents = EventSchedule::count();
        $this->totalActiveEvents = Event::whereStatus(true)->count();

    }

    public function placeholder()
    {
        return view('livewire.dashboard-skeleton');
    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}
