<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\UpdateMainReasonRequest;
use App\Models\MainReason;
use App\Repositories\MainReasonRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Laracasts\Flash\Flash;

class MainReasonController extends AppBaseController
{
    /** @var MainReasonRepository */
    private $mainReasonRepository;

    public function __construct(MainReasonRepository $mainReasonRepo)
    {
        $this->mainReasonRepository = $mainReasonRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(): \Illuminate\View\View
    {
        $mainReasons = MainReason::toBase()->pluck('value', 'key')->toArray();

        return view('fronts.main_reasons.index', compact('mainReasons'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return Application|Redirector|RedirectResponse
     */
    public function update(UpdateMainReasonRequest $request): RedirectResponse
    {
        $inputs = $request->all();
        $mainReason = $this->mainReasonRepository->updateMainReason($inputs);

        Flash::success(__('messages.success_message.main_reason_updated'));

        return redirect(route('main.reasons.index'));
    }
}
