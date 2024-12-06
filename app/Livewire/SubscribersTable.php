<?php

namespace App\Livewire;

use App\Models\Subscribe;
use Rappasoft\LaravelLivewireTables\Views\Column;

class SubscribersTable extends LivewireTableComponent
{
    protected $model = Subscribe::class;

    public string $tableName = 'subscribes';

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setDefaultSort('created_at', 'desc');
        $this->setTdAttributes(function (Column $column, $row, $columnIndex, $rowIndex) {
            if ($columnIndex == '1') {
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
        return view('livewire.search-listing-skeleton');
    }

    public function columns(): array
    {
        return [
            Column::make(__('messages.user.email'), 'email')
                ->sortable()->searchable(),
            Column::make(__('messages.common.action'), 'id')->view('subscribers.component.action'),
        ];
    }

    public function resetPageTable()
    {
        $this->customResetPage('subscribesPage');
    }
}
