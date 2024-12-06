<?php

namespace App\Livewire;

use App\Models\Currency;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;

class CurrenciesTable extends LivewireTableComponent
{
    public $showButtonOnHeader = true;

    public $showFilterOnHeader = false;

    public $buttonComponent = 'currencies.component.add_button';

    protected $model = Currency::class;

    public string $tableName = 'currencies';

    protected $listeners = ['refresh' => '$refresh'];

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setDefaultSort('created_at', 'desc');
        $this->setTdAttributes(function (Column $column, $row, $columnIndex, $rowIndex) {
            if ($columnIndex == '3') {
                return [
                    'style' => 'text-align:center,padding-left:0!important',
                    'width' => '8%',
                ];
            }

            return [];
        });
    }

    public function placeholder()
    {
        return view('livewire.currencies-skeleton');
    }

    public function columns(): array
    {
        return [
            Column::make(__('messages.currency.currency_name'), 'currency_name')
                ->view('currencies.component.currency_name')->searchable()->sortable(),
            Column::make(__('messages.currency.currency_icon'), 'currency_icon')
                ->view('currencies.component.currency_icon')->sortable()->searchable(),
            Column::make(__('messages.currency.currency_code'), 'currency_code')
                ->view('currencies.component.currency_code')->sortable()->searchable(),
            Column::make(__('messages.common.action'), 'id')->view('currencies.component.action'),
        ];
    }

    public function query(): Builder
    {
        return Currency::query();
    }

    public function resetPageTable()
    {
        $this->customResetPage('currenciesPage');
    }
}
