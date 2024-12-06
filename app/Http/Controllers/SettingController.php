<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateSettingRequest;
use App\Models\Currency;
use App\Repositories\SettingRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Redirect;
use Laracasts\Flash\Flash;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class SettingController extends AppBaseController
{
    /**
     * @var SettingRepository
     */
    private $settingRepository;

    /**
     * SettingController constructor.
     */
    public function __construct(SettingRepository $SettingRepository)
    {
        $this->settingRepository = $SettingRepository;
    }

    /**
     * @return Application|Factory|View
     */
    public function index(Request $request): \Illuminate\View\View
    {
        $currencies = Currency::toBase()->get();
        $sectionName = ($request->get('section') === null) ? 'general' : $request->get('section');

        return view("setting.$sectionName", compact('sectionName', 'currencies'));
    }

    /**
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function update(UpdateSettingRequest $request): RedirectResponse
    {
        $this->settingRepository->updateSetting($request->all());
        Flash::success(__('messages.success_message.setting_updated'));

        return Redirect::back();
    }

    public function removeHoldStatus(): RedirectResponse
    {
        Artisan::call('change:scheduled-event-status');

        Flash::success(__('messages.hold_status_remove'));

        return redirect(route('settings.index'));
    }

    public function settingCredential(Request $request): RedirectResponse
    {
        $this->settingRepository->updateSettingCredential($request->all());
        Flash::success(__('messages.success_message.setting_updated'));

        return Redirect::back();
    }
}
