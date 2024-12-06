<?php

namespace App\Livewire;

use App\Models\Enquiry;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;

class EnquiryTable extends LivewireTableComponent
{
    protected $model = Enquiry::class;

    public $showFilterOnHeader = true;

    public string $tableName = 'enquiries';

    public $statusFilter = Enquiry::ALL;

    public $FilterComponent = ['enquiries.component.status_filter', 1];

    protected $listeners = ['resetPageTable', 'refresh' => '$refresh', 'changeFilter'];

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setDefaultSort('created_at', 'desc')->setQueryStringStatus(false);
        $this->setTdAttributes(function (Column $column, $row, $columnIndex, $rowIndex) {
            if ($columnIndex == '6') {
                return [
                    'style' => 'text-align:center,padding-left:0!important',
                    'width' => '7%',
                ];
            } elseif ($columnIndex == '5') {
                return [
                    'width' => '10%',
                ];
            }

            return [];
        });
    }

    public function changeFilter($status)
    {
        $this->statusFilter = $status;
        $this->setBuilder($this->builder());
        $this->resetPagination();
    }

    public function placeholder()
    {
        return view('livewire.enquiries-skeleton');
    }

    public function columns(): array
    {
        return [
            Column::make(__('messages.enquiry.name'), 'first_name')
                ->view('enquiries.component.name')->sortable()->searchable(function (Builder $query, $direction) {
                    $query->whereRaw("TRIM(CONCAT(first_name,' ',last_name,' ')) like '%{$direction}%'");
                }),
            Column::make('Last name', 'last_name')->hideIf(1),
            Column::make(__('messages.common.email'), 'email')->hideIf(1),
            Column::make(__('messages.enquiry.message'), 'message')
                ->sortable()->searchable()->view('enquiries.component.message'),
            Column::make(__('messages.enquiry.status'), 'view')->view('enquiries.component.status')->sortable(),
            Column::make(__('messages.enquiry.created_at'),
                'created_at')->view('enquiries.component.created_at')->sortable(),
            Column::make(__('messages.common.action'), 'id')->view('enquiries.component.action'),
        ];
    }

    public function builder(): Builder
    {
        $query = Enquiry::query();
        
        $query->when($this->statusFilter != 2, function (Builder $q) {
            $q->where('view', $this->statusFilter);
        });

        return $query;
    }

    public function resetPageTable()
    {
        $this->customResetPage('enquiriesPage');
    }

    public function resetPagination()
    {
        $this->resetPage('enquiriesPage');
    }
}
