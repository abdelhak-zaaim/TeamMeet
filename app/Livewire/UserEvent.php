<?php

namespace App\Livewire;

use App\Mail\DeleteEventMail;
use App\Models\Event;
use App\Models\EventSchedule;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Mail;
use Str;

class UserEvent extends SearchableComponent
{
    public $user_id;

    public $numberOfPaginatorsRendered;

    public function mount($user_id)
    {
        $this->user_id = $user_id;
    }


    public function model(): string
    {
        return Event::class;
    }

    public function placeholder()
    {
        return view('livewire.front-user-event-skeleton');
    }

    public function render()
    {
        $events = $this->getQuery()->with('user')->where('user_id', '=', $this->user_id)->paginate();
        return view('livewire.user-event', compact('events'));
    }

    /**
     * @return string[]
     */
    public function searchableFields(): array
    {
        return ['name'];
    }
}
