<?php

namespace App\Livewire;

use App\Models\Faq;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;

class FaqTable extends LivewireTableComponent
{
    public $showButtonOnHeader = true;

    public $buttonComponent = 'fronts.faqs.component.add_button';

    protected $model = Faq::class;

    public string $tableName = 'faqs';

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setDefaultSort('created_at', 'desc');
        $this->setTdAttributes(function (Column $column, $row, $columnIndex, $rowIndex) {
            if ($columnIndex == '2') {
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
            Column::make(__('messages.faq.question'), 'question')
                ->searchable()
                ->sortable(),
            Column::make(__('messages.faq.answer'), 'answer')
                ->searchable()
                ->sortable(),
            Column::make(__('messages.common.action'), 'id')->view('fronts.faqs.component.action'),
        ];
    }

    public function builder(): Builder
    {
        return Faq::query();
    }

    public function resetPageTable()
    {
        $this->customResetPage('faqsPage');
    }
}
