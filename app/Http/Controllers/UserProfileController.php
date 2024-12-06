<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateChangePasswordRequest;
use App\Http\Requests\UpdateUserProfileRequest;
use App\Models\User;
use App\Repositories\UserProfileRepository;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Hash;
use Laracasts\Flash\Flash;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class UserProfileController extends AppBaseController
{
    private $userProfileRepo;

    public function __construct(UserProfileRepository $userProfileRepo)
    {
        $this->userProfileRepo = $userProfileRepo;
    }

    /**
     * @return Application|Factory|View
     */
    public function editProfile(): \Illuminate\View\View
    {
        $user = getLogInUser();

        return view('profile.index', compact('user'));
    }

    /**
     * @return Application|RedirectResponse|Redirector
     */
    public function updateProfile(UpdateUserProfileRequest $request): RedirectResponse
    {
        $this->userProfileRepo->updateProfile($request->all());

        Flash::success(__('messages.success_message.user_profile_updated'));

        return redirect(route('profile.setting'));
    }

    public function changePassword(UpdateChangePasswordRequest $request): JsonResponse
    {
        $input = $request->all();

        try {
            /** @var User $user */
            $user = getLogInUser();
            if (! Hash::check($input['current_password'], $user->password)) {
                return $this->sendError(__('messages.success_message.current_password_invalid'));
            }
            $input['password'] = Hash::make($input['new_password']);
            $user->update($input);

            return $this->sendSuccess(__('messages.success_message.password_updated'));
        } catch (Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }
}
