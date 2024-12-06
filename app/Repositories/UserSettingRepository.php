<?php

namespace App\Repositories;

use App\Models\UserSetting;
use Illuminate\Support\Arr;

/**
 * Class UserRepository
 */
class UserSettingRepository extends BaseRepository
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
        return UserSetting::class;
    }

    public function userUpdateSetting(array $input): void
    {
        $inputArr = Arr::except($input, ['_token']);

        if (! isset($inputArr['stripe_enable'])) {
            $inputArr = Arr::add($inputArr, 'stripe_enable', 0);
        }

        if (! isset($inputArr['paypal_enable'])) {
            $inputArr = Arr::add($inputArr, 'paypal_enable', 0);
        }

        if (! isset($inputArr['paystack_enable'])) {
            $inputArr = Arr::add($inputArr, 'paystack_enable', 0);
        }

        if (! isset($inputArr['razorpay_enable'])) {
            $inputArr = Arr::add($inputArr, 'razorpay_enable', 0);
        }

        foreach ($inputArr as $key => $value) {
            /** @var UserSetting $UserSetting */
            $UserSetting = UserSetting::whereUserId(getLogInUserId())->where('key', '=', $key)->first();

            if (! $UserSetting) {
                UserSetting::create([
                    'user_id' => getLogInUserId(),
                    'key' => $key,
                    'value' => $value,
                ]);
            } else {
                $UserSetting->update(['value' => $value]);
            }
        }
    }
}
