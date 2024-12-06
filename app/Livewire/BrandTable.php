<?php

namespace App\Livewire;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;

class BrandTable extends LivewireTableComponent
{
    protected $model = Brand::class;

    public $showButtonOnHeader = true;

    public string $tableName = 'brands';

    public $buttonComponent = 'brands.component.add_button';

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setDefaultSort('created_at', 'desc');
        $this->setSearchStatus(false);
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
        return view('livewire.brands-skeleton');
    }
    
    public function columns(): array
    {
        return [
            Column::make(__('messages.brand.logo'), 'id')->view('brands.component.logo'),
            Column::make(__('messages.common.action'), 'id')->view('brands.component.action'),
        ];
    }

    public function builder(): Builder
    {
        return Brand::query()->with('media')->select('brands.*');
    }

    public function resetPageTable()
    {
        $this->customResetPage('brandsPage');
    }
}
