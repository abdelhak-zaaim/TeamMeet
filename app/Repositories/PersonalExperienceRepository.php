<?php

namespace App\Repositories;

use App\Models\PersonalExperience;

/**
 * Class PersonalExperienceRepository
 *
 * @version October 14, 2022, 10:43 am UTC
 */
class PersonalExperienceRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
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
        return PersonalExperience::class;
    }
}
