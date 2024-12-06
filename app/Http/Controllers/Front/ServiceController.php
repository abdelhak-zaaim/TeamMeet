<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\UpdateServiceRequest;
use App\Models\Service;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Laracasts\Flash\Flash;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class ServiceController extends AppBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(): \Illuminate\View\View
    {
        $services = Service::toBase()->pluck('value', 'key')->toArray();

        return view('fronts.services.index', compact('services'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Application|RedirectResponse|Redirector
     *
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function update(UpdateServiceRequest $request): RedirectResponse
    {
        $data = [];
        $input = $request->all();
        $data['service_title_1'] = $input['service_title_1'];
        $data['service_title_2'] = $input['service_title_2'];
        $data['service_title_3'] = $input['service_title_3'];
        $data['service_description_1'] = $input['service_description_1'];
        $data['service_description_2'] = $input['service_description_2'];
        $data['service_description_3'] = $input['service_description_3'];
        $data['main_title'] = $input['main_title'];

        if (isset($input['service_image_1'])) {
            /** @var Service $service */
            $service = Service::where('key', 'service_image_1')->first();
            $service->clearMediaCollection(Service::SERVICE_ICON);
            $media = $service->addMedia($input['service_image_1'])->toMediaCollection(Service::SERVICE_ICON,
                config('app.media_disc'));
            $service->update(['value' => $media->getUrl()]);
        }
        if (isset($input['service_image_2'])) {
            $service = Service::where('key', 'service_image_2')->first();
            $service->clearMediaCollection(Service::SERVICE_ICON);
            $media = $service->addMedia($input['service_image_2'])->toMediaCollection(Service::SERVICE_ICON,
                config('app.media_disc'));
            $service->update(['value' => $media->getUrl()]);
        }
        if (isset($input['service_image_3'])) {
            $service = Service::where('key', 'service_image_3')->first();
            $service->clearMediaCollection(Service::SERVICE_ICON);
            $media = $service->addMedia($input['service_image_3'])->toMediaCollection(Service::SERVICE_ICON,
                config('app.media_disc'));
            $service->update(['value' => $media->getUrl()]);
        }

        foreach ($data as $key => $value) {
            /** @var Service $service */
            $service = Service::where('key', $key)->first();
            if (! $service) {
                continue;
            }
            $service->update(['value' => $value]);
        }

        Flash::success(__('messages.success_message.service_updated'));

        return redirect(route('front.service.update'));
    }
}
