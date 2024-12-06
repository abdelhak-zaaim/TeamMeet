<?php

namespace App\Livewire;

use App\Models\EventSchedule;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;

class EventScheduledEventTable extends LivewireTableComponent
{
    public $showButtonOnHeader = false;

    public string $tableName = 'event_schedules';

    public $eventId;

    protected $model = EventSchedule::class;

    public function mount($eventId)
    {
        $this->eventId = $eventId;
    }

    public function placeholder()
    {
        return view('livewire.search-listing-skeleton');
    }
    
    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setDefaultSort('event_schedules.created_at', 'desc');
        $this->setTdAttributes(function (Column $column, $row, $columnIndex, $rowIndex) {
            if ($columnIndex == '7') {
                return [
                    'style' => 'text-align:center,padding-left:0!important',
                    'width' => '8%',
                ];
            }

            return [];
        });
    }

    public function columns(): array
    {
        return [
            Column::make(__('messages.common.name'), 'name')
                ->sortable()->searchable()->view('schedule_event.component.name'),
            Column::make(__('messages.common.email'), 'email')->hideIf(true),
            Column::make(__('messages.event.event_name'), 'event_id')->hideIf(true),
            Column::make(__('messages.schedule_event.scheduled_date'), 'schedule_date')
                ->sortable()->view('schedule_event.component.scheduled_date'),
            Column::make(__('messages.schedule_event.scheduled_time'), 'slot_time')
                ->sortable()->view('schedule_event.component.scheduled_time'),
            Column::make('User schedule id', 'user_schedule_id')->hideIf(true),
            Column::make(__('messages.schedule_event.status'), 'status')
                ->view('schedule_event.component.status'),
            Column::make(__('messages.common.action'), 'id')->view('schedule_event.component.action'),
        ];
    }

    public function builder(): Builder
    {
        $query = EventSchedule::with(['event'])->where('user_id', getLogInUserId())
            ->where('event_id', $this->eventId);

        return $query;
    }

    public function resetPageTable()
    {
        $this->customResetPage('event_schedulesPage');
    }
}
