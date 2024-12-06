<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\CreateFrontCMSSettingRequest;
use App\Models\FrontCMSSetting;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Arr;
use Laracasts\Flash\Flash;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class FrontCMSController extends AppBaseController
{
    /**
     * @return Application|Factory|View
     */
    public function index(): \Illuminate\View\View
    {
        $cmsData = FrontCMSSetting::toBase()->pluck('value', 'key')->toArray();

        return view('fronts.cms.cms', compact('cmsData'));
    }

    /**
     * @return Application|RedirectResponse|Redirector
     *
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function update(CreateFrontCMSSettingRequest $request): RedirectResponse
    {
        $inputs = $request->all();
        $inputs = Arr::except($inputs, ['_token']);
        $inputs['terms_conditions'] = json_decode($inputs['terms_conditions']);
        $inputs['privacy_policy'] = json_decode($inputs['privacy_policy']);

        foreach ($inputs as $key => $value) {

            /** @var FrontCMSSetting $cmsSetting */
            $cmsSetting = FrontCMSSetting::where('key', $key)->first();
            if (! $cmsSetting) {
                continue;
            }

            $cmsSetting->update(['value' => $value]);

            if (in_array($key, ['front_image']) && ! empty($value)) {
                $cmsSetting->clearMediaCollection(FrontCMSSetting::FRONT_IMAGE);
                $media = $cmsSetting->addMedia($value)->toMediaCollection(FrontCMSSetting::FRONT_IMAGE,
                    config('app.media_disc'));
                $cmsSetting->update(['value' => $media->getUrl()]);
            }
        }

        Flash::success(__('messages.success_message.cms_update'));

        return redirect(route('front.cms.index'));
    }
}
