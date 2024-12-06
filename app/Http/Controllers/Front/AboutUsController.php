<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\UpdateAboutUsRequest;
use App\Models\FrontCMSSetting;
use Flash;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class AboutUsController extends AppBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(): \Illuminate\View\View
    {
        $aboutUs = getFrontCMSSetting();

        return view('fronts.about_us.index', compact('aboutUs'));
    }

    /**
     * @return Application|RedirectResponse|Redirector
     */
    public function update(UpdateAboutUsRequest $request): RedirectResponse
    {
        $inputs = $request->all();
        $inputs['about_us_description'] = json_decode($inputs['about_us_description']);

        foreach ($inputs as $key => $value) {
            $aboutUs = FrontCMSSetting::where('key', $key)->first();
            if (! $aboutUs) {
                continue;
            }
            $aboutUs->update(['value' => $value]);
        }

        Flash::success(__('messages.success_message.about_us_updated'));

        return redirect(route('about.us.index'));
    }
}
