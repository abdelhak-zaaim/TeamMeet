<?php

namespace App\Repositories;

use App\Models\Brand;

/**
 * Class BrandRepository
 *
 * @version December 24, 2021, 7:27 am UTC
 */
class BrandRepository extends BaseRepository
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
    public function model(): string
    {
        return Brand::class;
    }

    public function store($input): Brand
    {
        $brand = new Brand();
        $brand->save();

        if (isset($input['brand_logo']) && ! empty($input['brand_logo'])) {
            $brand->addMedia($input['brand_logo'])->toMediaCollection(Brand::BRAND_LOGO, config('app.media_disc'));
        }

        return $brand;
    }

    public function update($input, $id): Brand
    {
        $brand = Brand::findOrFail($id);

        if (isset($input['brand_logo']) && ! empty($input['brand_logo'])) {
            $brand->clearMediaCollection(Brand::BRAND_LOGO);
            $brand->addMedia($input['brand_logo'])->toMediaCollection(Brand::BRAND_LOGO, config('app.media_disc'));
        }

        return $brand;
    }
}
