<?php

namespace App\Repositories;

use App\Models\Faq;

/**
 * Class FaqRepository
 *
 * @version Dec 27, 2021, 12:51 pm UTC
 */
class FaqRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [

    ];

    /**
     * Return searchable fields
     */
    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Faq::class;
    }
}
