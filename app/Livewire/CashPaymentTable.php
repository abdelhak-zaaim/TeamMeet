<?php

namespace App\Livewire;

use App\Models\Subscription;
use App\Models\UserTransaction;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;

class CashPaymentTable extends LivewireTableComponent
{
    protected $model = UserTransaction::class;

    protected $listeners = ['resetPageTable', 'refresh' => '$refresh', 'changeStatus', 'getNoteData'];

    public function configure(): void
    {
        $this->setPrimaryKey('id')->setQueryStringStatus(false);
        $this->setDefaultSort('created_at', 'desc');

        $this->setThAttributes(function (Column $column) {
            if ($column->isField('price')) {
                return [
                    'class' => 'text-end',
                ];
            }
            if ($column->isField('amount')) {
                return [
                    'class' => 'd-flex justify-content-end',
                ];
            }
            if ($column->isField('subscription_status')){
                return [
                    'style' => 'min-width:240px !important',
                ];
            }

            return [];
        });
        $this->setTdAttributes(function (Column $column, $row, $columnIndex, $rowIndex) {
            if ($column->isField('subscription_status')){
                return [
                    'style' => 'min-width:240px !important',
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
            Column::make(__('messages.users'), 'user.first_name')
                ->searchable(function (Builder $query, $direction) {
                    $query->whereRaw("TRIM(CONCAT(first_name,' ',last_name,' ')) like '%{$direction}%'");
                })
                ->sortable()
                ->view('cash_payments.components.user_name'),
            Column::make(__('messages.users'), 'user.last_name')
                ->searchable()
                ->sortable()
                ->view('cash_payments.components.user_name')->hideIf(1),
            Column::make(__('messages.common.status'), 'subscription_status')
                ->sortable()
                ->view('cash_payments.components.subscription_status'),
            Column::make(__('messages.subscription_plan.plan_name'), 'transactionSubscription.SubscriptionPlan.name')
                ->searchable()
                ->sortable()
                ->view('cash_payments.components.plan_name'),
            Column::make(__('messages.cash_payment.plan_price'), 'transactionSubscription.SubscriptionPlan.price')
                ->searchable()
                ->sortable()
                ->view('cash_payments.components.plan_price'),
            Column::make(__('messages.cash_payment.payable_amount'), 'amount')
                ->sortable()
                ->searchable()
                ->view('cash_payments.components.payable_amount'),
            Column::make(__('messages.cash_payment.start_date'), 'transactionSubscription.starts_at')
                ->sortable()
                ->searchable()
                ->view('cash_payments.components.start_date'),
            Column::make(__('messages.cash_payment.end_date'), 'transactionSubscription.ends_at')
                ->sortable()
                ->searchable()
                ->view('cash_payments.components.end_date'),
            Column::make(__('messages.cash_payment.attachment'), 'id')
                ->view('cash_payments.components.attachment'),
            Column::make(__('messages.cash_payment.note'), 'note')
                ->sortable()
                ->searchable()
                ->view('cash_payments.components.note'),
        ];
    }

    public function builder(): Builder
    {
        return UserTransaction::with(['media', 'user', 'transactionSubscription.SubscriptionPlan'])
            ->wherePaymentType(UserTransaction::MANUALLY)
            ->select('user_transactions.*');
    }

    public function changeStatus($id, $status)
    {
        $userTransaction = UserTransaction::with('transactionSubscription')->find($id);

        if ($status == UserTransaction::APPROVED) {
            $userTransaction->update(['subscription_status' => $status]);
            $subscription = $userTransaction->transactionSubscription;

            Subscription::find($subscription->id)->update(['status' => Subscription::ACTIVE]);

            Subscription::whereUserId($subscription->user_id)
                ->where('id', '!=', $subscription->id)
                ->update([
                    'status' => Subscription::INACTIVE,
                ]);

            $subscription->update([
                'status', Subscription::ACTIVE,
                'transaction_id' => $userTransaction->id,
            ]);
        }

        if ($status == UserTransaction::REJECTED) {
            $userTransaction->update(['subscription_status' => $status]);
            $subscription = $userTransaction->transactionSubscription;

            //            $subscription->update(['status' => Subscription::INACTIVE]);
            //            Subscription::whereUserId($subscription->user_id)
            //                ->where('id', '!=', $subscription->id)
            //                ->update([
            //                    'status' => Subscription::ACTIVE,
            //                ]);
        }

        $this->setBuilder($this->builder());
        $this->dispatch('changeStatusEvent');
    }

    public function getNoteData($userTransactionId)
    {
        $userTransaction = UserTransaction::find($userTransactionId);
        $note = $userTransaction->note;
        $this->dispatch('retrieveNoteData', $note);
    }
}
