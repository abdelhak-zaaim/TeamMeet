<?php

namespace App\Livewire;

use App\Models\PersonalExperience;
use Rappasoft\LaravelLivewireTables\Views\Column;

class PersonalExperienceTable extends LivewireTableComponent
{
    protected $model = PersonalExperience::class;

    public string $tableName = 'personal_experiences';

    public $showButtonOnHeader = true;

    public $buttonComponent = 'personal_experiences.component.add_button';

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
        return view('livewire.listing-skeleton');
    }

    public function columns(): array
    {
        return [
            Column::make(__('messages.common.name'), 'name')
                ->sortable()->searchable()->view('personal_experiences.component.name'),
            Column::make(__('messages.common.action'), 'id')->view('personal_experiences.component.action'),
        ];
    }

    public function resetPageTable()
    {
        $this->customResetPage('personal_experiencesPage');
    }
}
