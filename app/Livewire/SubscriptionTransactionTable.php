<?php

namespace App\Livewire;

use App\Models\UserTransaction;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;

class SubscriptionTransactionTable extends LivewireTableComponent
{
    protected $model = UserTransaction::class;

    public string $tableName = 'user_transactions';

    public function configure(): void
    {
        $this->setPrimaryKey('id')->setQueryStringStatus(false);
        $this->setDefaultSort('created_at', 'desc');
        $this->setTdAttributes(function (Column $column, $row, $columnIndex, $rowIndex) {
            if ($columnIndex == '6') {
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

            if ($column->getField() === 'status') {
                return [
                    'style' => 'text-align:center',
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
            if ($column->isField('status')) {
                return [
                    'class' => 'statusDiv',
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
            Column::make(__('messages.subscription_plan.plan_name'), 'transactionSubscription.SubscriptionPlan.name')
                ->sortable()
                ->searchable()->view('subscription_transactions.component.plan_name'),
            Column::make(__('messages.schedule_event.date'),
                'created_at')->view('subscription_transactions.component.payment_date')
                ->sortable(),
            Column::make(__('messages.schedule_event.payment_type'),
                'payment_type')
                ->sortable()
                ->view('subscription_transactions.component.payment_type'),
            Column::make('User id', 'user_id')->hideIf(1),
            Column::make(__('messages.schedule_event.amount'),
                'amount')->view('subscription_transactions.component.amount')
                ->sortable()->searchable(),
            Column::make(__('messages.common.status'), 'status')->view('subscription_transactions.component.status')
                ->sortable(),
            Column::make(__('messages.common.action'), 'id')->view('subscription_transactions.component.action'),
        ];
    }

    public function builder(): Builder
    {
        $query = UserTransaction::with(['transactionSubscription.SubscriptionPlan'])->where('payment_type', '!=', UserTransaction::MANUALLY);

        if (getLogInUser()->hasRole('user')) {
            $query->where('user_transactions.user_id', '=', getLogInUserId());
        }

        return $query;
    }

    public function resetPageTable()
    {
        $this->customResetPage('user_transactionsPage');
    }
}
