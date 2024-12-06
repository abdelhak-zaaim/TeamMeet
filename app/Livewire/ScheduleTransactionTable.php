<?php

namespace App\Livewire;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;

class ScheduleTransactionTable extends LivewireTableComponent
{
    protected $model = Transaction::class;

    public string $tableName = 'transactions';

    public function configure(): void
    {
        $this->setPrimaryKey('id')->setQueryStringStatus(false);
        $this->setDefaultSort('created_at', 'desc');
        $this->setTdAttributes(function (Column $column, $row, $columnIndex, $rowIndex) {
            if ($columnIndex == '8') {
                return [
                    'style' => 'text-align:center,padding-left:0!important',
                    'width' => '8%',
                ];
            }

            if ($column->getField() === 'amount') {
                return [
                    'style' => 'text-align:end',
                ];
            }

            return [];
        });

        $this->setThAttributes(function (Column $column) {
            if ($column->isField('amount')) {
                return [
                    'class' => 'amountDiv',
                ];
            }

            return [];
        });
    }

    public function placeholder()
    {
        return view('livewire.search-listing-skeleton');
    }

    public function columns(): array
    {
        return [
            Column::make(__('messages.common.name'), 'scheduleEvent.name')
                ->sortable()
                ->searchable()->view('transactions.component.name'),
            Column::make(__('messages.schedule_event.date'), 'created_at')
                ->sortable()->view('transactions.component.payment-date'),
            Column::make(__('messages.event.event_name'), 'scheduleEvent.event.name')
                ->sortable()
                ->searchable()->view('transactions.component.event_name'),
            Column::make(__('user_id'), 'user_id')->hideIf(1),
            Column::make(__('transaction_id'), 'transaction_id')->hideIf(1),
            Column::make(__('schedule_event_id'), 'schedule_event_id')->hideIf(1),
            Column::make(__('messages.schedule_event.payment_type'), 'type')
                ->sortable()
                ->view('transactions.component.payment_type'),
            Column::make(__('messages.schedule_event.amount'), 'amount')
                ->sortable()->view('transactions.component.amount'),
            Column::make(__('messages.common.action'), 'id')->view('transactions.component.action'),
        ];
    }

    public function builder(): Builder
    {
        $query = Transaction::with('scheduleEvent.event');

        if (getLogInUser()->hasRole('user')) {
            $query->where('transactions.user_id', '=', getLogInUserId());
        }

        return $query;
    }

    public function resetPageTable()
    {
        $this->customResetPage('transactionsPage');
    }
}
