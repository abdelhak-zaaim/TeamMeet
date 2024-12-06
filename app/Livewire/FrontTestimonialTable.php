<?php

namespace App\Livewire;

use App\Models\FrontTestimonial;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;

class FrontTestimonialTable extends LivewireTableComponent
{
    public $showButtonOnHeader = true;

    public $buttonComponent = 'fronts.front_testimonials.component.add_button';

    protected $model = FrontTestimonial::class;

    public string $tableName = 'front_testimonials';

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
            Column::make(__('messages.common.name'), 'name')
                ->searchable()
                ->sortable()
                ->view('fronts.front_testimonials.component.name'),
            Column::make(__('messages.front_testimonial.short_description'), 'short_description')
                ->searchable()
                ->sortable(),
            Column::make(__('messages.common.action'), 'id')->view('fronts.front_testimonials.component.action'),
        ];
    }

    public function builder(): Builder
    {
        return FrontTestimonial::query()->with('media')->select('front_testimonials.*');
    }

    public function resetPageTable()
    {
        $this->customResetPage('front_testimonialsPage');
    }
}
