<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

/**
 * Class UserProfileRepository
 */
class UserProfileRepository extends BaseRepository
{
    public $fieldSearchable = [
        'first_name',
        'last_name',
        'email',
        'contact',
        'dob',
        'gender',
        'status',
        'password',

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
        return User::class;
    }

    public function updateProfile(array $userInput): bool
    {
        try {
            DB::beginTransaction();

            $user = getLogInUser();

            $user->update($userInput);

            if ((! empty($userInput['profile']))) {
                $user->clearMediaCollection(User::PROFILE);
                $user->media()->delete();
                $user->addMedia($userInput['profile'])->toMediaCollection(User::PROFILE);
            }

            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollBack();

            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }
}
