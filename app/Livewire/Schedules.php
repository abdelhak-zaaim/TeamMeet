<?php

namespace App\Livewire;

use App\Models\Schedule;
use App\Models\UserSchedule;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;

class Schedules extends SearchableComponent
{
    public $filterSchedule = '';

    public $scheduleId = '';

    /**
     * @var string[]
     */
    protected $listeners = [
        'refresh' => '$refresh',
        'filterUserSchedule',
        'deleteSchedule',
    ];

    public function mount($scheduleId)
    {
        $this->filterSchedule = $scheduleId;
        $this->scheduleId = $scheduleId;
    }

    /**
     * @return Application|Factory|View
     */
    public function render()
    {
        $scheduleWeekDays = $this->searchSchdule();

        return view('livewire.schedules', compact('scheduleWeekDays'));
    }

    public function searchSchdule(): LengthAwarePaginator
    {
        $query = $this->getQuery()->where('user_id', getLogInUserId());

        $this->getQuery()->when($this->filterSchedule != '', function (Builder $q) {
            $userScheduleExist = UserSchedule::where('schedule_id', $this->filterSchedule)->exists();
            if ($userScheduleExist) {
                $q->where('schedule_id', $this->filterSchedule)->whereNull('event_id');
            } else {
                $q->where('schedule_id', defaultUserSchedule())->whereNull('event_id');
            }
        });

        return $query->paginate(100);
    }

    public function filterUserSchedule($scheduleId)
    {
        $this->filterSchedule = $scheduleId;
        $this->scheduleId = $scheduleId;
    }

    public function deleteSchedule($scheduleId): void
    {
        $schedule = Schedule::find($scheduleId);
        $exits = UserSchedule::whereScheduleId($schedule->id)->whereNotNull('event_id')->first();

        if ($schedule->is_default) {
            $msg2 = 'Default schedule can\'t be deleted.';
            $this->dispatch('error', $msg2);
        } else {
            if (! empty($exits) && $schedule->is_default == false) {
                $msg1 = 'This Schedule is used somewhere else.';
                $this->dispatch('error', $msg1);
            } else {
                $schedule->delete();
                $id = getLogInUser()->schedule()->first()->id;
                $this->filterSchedule = $id;
                $this->scheduleId = $id;
                $scheduleArr['name'] = Schedule::loginUser()->whereStatus(true)->pluck('schedule_name',
                    'id')->toArray();
                $scheduleArr['scheduleId'] = $id;

                $this->dispatch('deleted', $scheduleArr);
            }
        }
    }

    public function model()
    {
        return UserSchedule::class;
    }

    public function searchableFields()
    {
        //
    }
}
