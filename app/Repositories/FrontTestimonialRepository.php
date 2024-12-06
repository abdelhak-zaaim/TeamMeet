<?php

namespace App\Repositories;

use App\Models\FrontTestimonial;
use Exception;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

/**
 * Class FrontTestimonialRepository
 *
 * @version September 22, 2021, 11:20 am UTC
 */
class FrontTestimonialRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'designation',
        'short_description',
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
        return FrontTestimonial::class;
    }

    public function store($input): bool
    {
        try {
            DB::beginTransaction();

            $frontTestimonial = FrontTestimonial::create($input);

            if (isset($input['profile']) && ! empty($input['profile'])) {
                $frontTestimonial->addMedia($input['profile'])->toMediaCollection(FrontTestimonial::FRONT_PROFILE,
                    config('app.media_disc'));
            }

            DB::commit();

            return true;
        } catch (Exception $e) {
            DB::rollBack();
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    public function update($input, $id): bool
    {
        try {
            DB::beginTransaction();

            $frontTestimonial = FrontTestimonial::findOrFail($id);
            $frontTestimonial->update($input);

            if (isset($input['profile']) && ! empty($input['profile'])) {
                $frontTestimonial->clearMediaCollection(FrontTestimonial::FRONT_PROFILE);
                $frontTestimonial->media()->delete();
                $frontTestimonial->addMedia($input['profile'])->toMediaCollection(FrontTestimonial::FRONT_PROFILE,
                    config('app.media_disc'));
            }

            DB::commit();

            return true;
        } catch (Exception $e) {
            DB::rollBack();
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }
}
