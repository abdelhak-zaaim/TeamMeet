<?php

namespace App\Repositories;

use App\Models\MainReason;

/**
 * Class MainReasonRepository
 *
 * @version December 24, 2021, 7:27 am UTC
 */
class MainReasonRepository extends BaseRepository
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
        return MainReason::class;
    }

    public function updateMainReason($inputs): MainReason
    {
        foreach ($inputs as $key => $value) {
            /** @var MainReason $mainReason */
            $mainReason = MainReason::where('key', $key)->first();

            if (! $mainReason) {
                continue;
            }

            $mainReason->update(['value' => $value]);

            if (in_array($key, ['image']) && ! empty($value)) {
                $mainReason->clearMediaCollection(MainReason::MAIN_REASON_IMAGE);
                $media = $mainReason->addMedia($value)->toMediaCollection(MainReason::MAIN_REASON_IMAGE,
                    config('app.media_disc'));
                $mainReason->update(['value' => $media->getUrl()]);
            }
        }

        return $mainReason;
    }
}
