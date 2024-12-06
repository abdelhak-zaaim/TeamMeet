<?php

namespace App\Http\Controllers;

use App\Models\UserSetting;
use App\Repositories\UserSettingRepository;
use Flash;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Arr;
use Illuminate\View\View;

class UserSettingController extends AppBaseController
{
    /**
     * @var UserSettingRepository
     */
    private $UserSettingRepository;

    /**
     * SettingController constructor.
     */
    public function __construct(UserSettingRepository $UserSettingRepository)
    {
        $this->UserSettingRepository = $UserSettingRepository;
    }

    /**
     * @return Application|Factory
     */
    public function index(Request $request): View
    {
        $setting = UserSetting::where('user_id', getLogInUserId())->pluck('value', 'key')->toArray();
        $sectionName = ($request->get('section') === null) ? 'general' : $request->get('section');

        return view("user_settings.$sectionName", compact('sectionName', 'setting'));
    }

    /**
     * @return Application|RedirectResponse|Redirector
     */
    public function store(Request $request): RedirectResponse
    {
        $inputs = Arr::except($request->all(), ['_token']);

        if (! isset($inputs['email_notification'])) {
            $inputs = Arr::add($inputs, 'email_notification', 0);
        }

        foreach ($inputs as $key => $value) {
            $this->createOrUpdate($key, $value);
        }

        Flash::success(__('messages.success_message.setting_updated'));

        return redirect(route('user.settings'));
    }

    /**
     * @return bool
     */
    public function createOrUpdate($key, $value)
    {
        $userSetting = UserSetting::whereUserId(getLogInUserId())->where('key', '=', $key)->first();

        if (! empty($userSetting)) {
            $userSetting->update(['value' => $value]);
        } else {
            UserSetting::create([
                'user_id' => getLogInUserId(),
                'key' => $key,
                'value' => $value,
            ]);
        }

        return true;
    }

    /**
     * @return Application|Redirector|RedirectResponse
     */
    public function userCredentialUpdate(Request $request): RedirectResponse
    {
        $this->UserSettingRepository->userUpdateSetting($request->all());
        Flash::success(__('messages.success_message.setting_updated'));

        return redirect(route('user.settings', ['section' => 'credentials']));
    }
}
