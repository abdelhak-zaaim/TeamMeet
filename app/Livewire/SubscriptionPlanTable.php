<?php

namespace App\Livewire;

use App\Models\SubscriptionPlan;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;

class SubscriptionPlanTable extends LivewireTableComponent
{
    public $showFilterOnHeader = true;

    public $showButtonOnHeader = true;

    public $buttonComponent = 'subscription_plans.component.add_button';

    protected $model = SubscriptionPlan::class;

    public string $tableName = 'subscription_plans';

    public $statusFilter;

    protected $listeners = ['resetPageTable', 'refresh' => '$refresh', 'changeFilter'];

    public $FilterComponent = ['subscription_plans.component.filter_button', SubscriptionPlan::PLAN_TYPE];

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setDefaultSort('created_at', 'desc');
        $this->setTdAttributes(function (Column $column, $row, $columnIndex, $rowIndex) {
            if ($columnIndex == '6') {
                return [
                    'style' => 'text-align:center,padding-left:0!important',
                    'width' => '10%',
                ];
            } elseif ($columnIndex == '5') {
                return [
                    'style' => 'text-align:center,padding-left:0!important',
                    'width' => '10%',
                ];
            }

            if ($column->getField() === 'price') {
                return [
                    'style' => 'text-align:end',
                ];
            }

            if ($column->getField() === 'frequency') {
                return [
                    'style' => 'text-align:center',
                ];
            }

            return [];
        });

        $this->setThAttributes(function (Column $column) {
            if ($column->isField('price')) {
                return [
                    'class' => 'priceDiv',
                ];
            }
            if ($column->isField('frequency')) {
                return [
                    'style' => 'text-align:center',
                ];
            }

            return [];
        });
    }

    public function placeholder()
    {
        return view('livewire.subscription-plans-skeleton');
    }

    public function columns(): array
    {
        return [
            Column::make(__('messages.subscription_plan.name'), 'name')
                ->sortable()->searchable(),
            Column::make(__('messages.subscription_plan.price'), 'price')
                ->sortable()->searchable()->view('subscription_plans.component.price'),
            Column::make(__('messages.subscription_plan.plan_type'), 'frequency')
                ->view('subscription_plans.component.frequency'),
            Column::make(__('messages.subscription_plan.valid_until'), 'trial_days')
                ->sortable()->view('subscription_plans.component.trial_days'),
            Column::make(__('messages.subscription_plan.active_plan'), 'id')
                ->view('subscription_plans.component.active_plan'),
            Column::make(__('messages.subscription_plan.make_default'), 'is_default')
                ->sortable()->view('subscription_plans.component.make_default'),
            Column::make(__('messages.common.action'), 'id')->view('subscription_plans.component.action'),
        ];
    }

    public function changeFilter($value)
    {
        $this->statusFilter = $value;
        $this->setBuilder($this->builder());
        $this->resetPagination();
    }



    public function builder(): Builder
    {
        $query = SubscriptionPlan::with('subscriptions')->select('subscription_plans.*');

        $query->when(isset($this->statusFilter), function (Builder $q) {
            $q->where('subscription_plans.frequency', $this->statusFilter);
        });

        return $query;
    }

    public function resetPageTable()
    {
        $this->customResetPage('subscription_plansPage');
    }

    public function resetPagination()
    {
        $this->resetPage('subscription_plansPage');
    }
}
