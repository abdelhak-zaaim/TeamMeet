<?php

namespace App\Repositories;

use App\Models\Setting;
use Illuminate\Support\Arr;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

/**
 * Class SettingRepository
 */
class SettingRepository extends BaseRepository
{
    public $fieldSearchable = [
        'application_name',
    ];

    /**
     * {@inheritDoc}
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * {@inheritDoc}
     */
    public function model()
    {
        return Setting::class;
    }

    /**
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function updateSetting($input)
    {
        $inputArr = Arr::except($input, ['_token']);
        if (! isset($inputArr['auto_detect_location_enable'])) {
            $inputArr = Arr::add($inputArr, 'auto_detect_location_enable', 0);
        }

        if (! isset($inputArr['enable_google_recaptcha'])) {
            $inputArr = Arr::add($inputArr, 'enable_google_recaptcha', 0);
        }
        
        foreach ($inputArr as $key => $value) {
            /** @var Setting $setting */
            $setting = Setting::where('key', $key)->first();

            if (! $setting) {
                continue;
            }

            $setting->update(['value' => $value]);

            if (in_array($key, ['logo']) && ! empty($value)) {
                $setting->clearMediaCollection(Setting::LOGO);
                $media = $setting->addMedia($value)->toMediaCollection(Setting::LOGO, config('app.media_disc'));
                $setting->update(['value' => $media->getUrl()]);
            }

            if (in_array($key, ['favicon']) && ! empty($value)) {
                $setting->clearMediaCollection(Setting::FAVICON);
                $media = $setting->addMedia($value)->toMediaCollection(Setting::FAVICON, config('app.media_disc'));
                $setting->update(['value' => $media->getUrl()]);
            }
        }
    }

    public function updateSettingCredential($input)
    {
        $inputArr = Arr::except($input, ['_token', 'sectionName']);

        if (! isset($inputArr['stripe_checkbox_btn'])) {
            $inputArr = Arr::add($inputArr, 'stripe_checkbox_btn', 0);
        }

        if (! isset($inputArr['paypal_checkbox_btn'])) {
            $inputArr = Arr::add($inputArr, 'paypal_checkbox_btn', 0);
        }

        if (! isset($inputArr['paystack_checkbox_btn'])){
            $inputArr = Arr::add($inputArr, 'paystack_checkbox_btn', 0);
        }

        foreach ($inputArr as $key => $value) {
            /** @var Setting $setting */
            $setting = Setting::where('key', $key)->first();
            if (! $setting) {
                Setting::create([
                    'key' => $key,
                    'value' => $value,
                ]);
            } else {
                $setting->update(['value' => $value]);
            }
        }
    }
}
