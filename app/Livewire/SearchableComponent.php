<?php

namespace App\Livewire;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;
use Livewire\WithPagination;
use Str;

abstract class SearchableComponent extends Component
{
    /**
     * @var string
     */
    public $search = '';

    use WithPagination;

    /**
     * @var int
     */
    public $paginate = 12;

    protected $paginationTheme = 'bootstrap';

    /** @var Builder */
    private $query;

    /**
     * SearchableComponent constructor.
     */
    public function __construct()
    {
//         parent::__construct($id);

        $this->prepareModelQuery();
    }

    /**
     *  Prepare query
     */
    private function prepareModelQuery()
    {
        /** @var Model $model */
        $model = app($this->model());

        $this->query = $model->newQuery();
    }

    /**
     * @return mixed
     */
    abstract public function model();

    /**
     * Reset model query
     */
    protected function resetQuery()
    {
        $this->prepareModelQuery();
    }

    /**
     * @return Builder
     */
    protected function getQuery()
    {
        return $this->query;
    }

    protected function setQuery(Builder $query)
    {
        $this->query = $query;
    }

    /**
     * @param  bool  $search
     * @return LengthAwarePaginator
     */
    protected function paginate($search = true)
    {
        if ($search) {
            $this->filterResults();
        }

        $all = $this->query->paginate($this->paginate);
        $currentPage = $all->currentPage();
        $lastPage = $all->lastPage();
        if ($currentPage > $lastPage) {
            $this->page = $lastPage;
        }

        return $this->query->paginate($this->paginate);
    }

    /**
     * @return Builder
     */
    protected function filterResults()
    {
        $searchableFields = $this->searchableFields();
        $search = $this->search;

        $this->query->when(! empty($search), function (Builder $q) use ($search, $searchableFields) {
            $searchString = '%'.$search.'%';
            foreach ($searchableFields as $field) {
                if (Str::contains($field, '.')) {
                    $field = explode('.', $field);
                    $q->orWhereHas($field[0], function (Builder $query) use ($field, $searchString) {
                        $query->whereRaw("lower($field[1]) like ?", $searchString);
                    });
                } else {
                    $q->orWhereRaw("lower($field) like ?", $searchString);
                }
            }
        });

        return $this->query;
    }

    /**
     * @return mixed
     */
    abstract public function searchableFields();
}
