<?php

namespace App\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Exceptions\DataTableConfigurationException;

/**
 * Class LivewireTableComponent
 */
class LivewireTableComponent extends DataTableComponent
{
    protected bool $columnSelectStatus = false;

    public $showFilterOnHeader = false;

    public $paginationIsEnabled = false;

    public bool $paginationStatus = true;

    public bool $sortingPillsStatus = false;

    protected $listeners = ['resetPageTable', 'refresh' => '$refresh'];

    public string $emptyMessage = ('messages.common.no_data_available');

    // for table header button
    public $showButtonOnHeader = false;

    public $buttonComponent = '';

    public function configure(): void
    {
        // TODO: Implement configure() method.
    }

    public function columns(): array
    {
        // TODO: Implement columns() method.
    }

    /**
     * @throws DataTableConfigurationException
     */
//     public function mountWithPagination(): void
//     {
//         if ($this->getPerPage()) {
//             $this->getPerPageAccepted()[] = -1;
//         }

//         $this->setPerPage($this->getPerPageAccepted()[0] ?? 10);
//     }

    public function customResetPage($pageName = 'page')
    {
        $rowsPropertyData = $this->getRows()->toArray();
        if ($this->searchStatus) {
            $prevPageNum = 0;
        } else {
            $prevPageNum = $rowsPropertyData['current_page'] - 1;
        }
        $prevPageNum = $prevPageNum > 0 ? $prevPageNum : 1;
        $pageNum = count($rowsPropertyData['data']) > 0 ? $rowsPropertyData['current_page'] : $prevPageNum;

        $this->setPage($pageNum, $pageName);
    }

    //    public function getQueryString(): array
    //    {
    //        return array_merge(['page' => ['except' => 1]], $this->queryString);
    //    }
}
