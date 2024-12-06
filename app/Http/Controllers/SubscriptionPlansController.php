<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSubscriptionPlansRequest;
use App\Http\Requests\UpdateSubscriptionPlansRequest;
use App\Models\SubscriptionPlan;
use App\Repositories\SubscriptionPlansRepository;
use Flash;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class SubscriptionPlansController extends AppBaseController
{
    /** @var SubscriptionPlansRepository */
    private $subscriptionPlansRepository;

    public function __construct(SubscriptionPlansRepository $subscriptionPlansRepo)
    {
        $this->subscriptionPlansRepository = $subscriptionPlansRepo;
    }

    /**
     * Display a listing of the SubscriptionPlans.
     *
     * @return Application|Factory|View
     */
    public function index(): \Illuminate\View\View
    {
        return view('subscription_plans.index');
    }

    /**
     * Show the form for creating a new SubscriptionPlans.
     *
     * @return Application|Factory|View
     */
    public function create(): \Illuminate\View\View
    {
        $planType = $this->subscriptionPlansRepository->planType();

        return view('subscription_plans.create', compact('planType'));
    }

    /**
     * Store a newly created SubscriptionPlans in storage.
     *
     * @return Application|RedirectResponse|Redirector
     */
    public function store(CreateSubscriptionPlansRequest $request): RedirectResponse
    {
        $input = $request->all();
        $subscriptionPlans = $this->subscriptionPlansRepository->store($input);

        Flash::success(__('messages.success_message.subscription_plan_added'));

        return redirect(route('subscription-plans.index'));
    }

    /**
     * Display the specified SubscriptionPlans.
     *
     * @return Application|Factory|Redirector|RedirectResponse|View
     */
    public function show(int $id)
    {
        $subscriptionPlans = SubscriptionPlan::with('planFeature')->find($id);

        if (empty($subscriptionPlans)) {
            Flash::error(__('messages.success_message.subscription_plan_not_found'));

            return redirect(route('subscription-plans.index'));
        }

        return view('subscription_plans.show', compact('subscriptionPlans'));
    }

    /**
     * Show the form for editing the specified SubscriptionPlans.
     *
     * @return Application|Factory|Redirector|RedirectResponse|View
     */
    public function edit(int $id)
    {
        $subscriptionPlans = $this->subscriptionPlansRepository->find($id);
        $planType = $this->subscriptionPlansRepository->planType();

        if (empty($subscriptionPlans)) {
            Flash::error(__('messages.success_message.subscription_plan_not_found'));

            return redirect(route('subscription-plans.index'));
        }

        return view('subscription_plans.edit', compact('planType', 'subscriptionPlans'));
    }

    /**
     * Update the specified SubscriptionPlans in storage.
     *
     * @return Application|Redirector|RedirectResponse
     */
    public function updateSubscriptionPlan(int $id, UpdateSubscriptionPlansRequest $request): RedirectResponse
    {
        $subscriptionPlans = $this->subscriptionPlansRepository->find($id);

        if (empty($subscriptionPlans)) {
            Flash::error(__('messages.success_message.subscription_plan_not_found'));

            return redirect(route('subscription-plans.index'));
        }

        $input = $request->all();
        $subscriptionPlans = $this->subscriptionPlansRepository->update($input, $id);

        Flash::success(__('messages.success_message.plan_updated'));

        return redirect(route('subscription-plans.index'));
    }

    public function destroy(SubscriptionPlan $subscriptionPlan): JsonResponse
    {
        $subscriptionPlan->delete();

        return $this->sendSuccess(__('messages.success_message.subscription_plan_deleted_successfully'));
    }

    public function makePlanDefault(int $id): JsonResponse
    {
        $defaultSubscriptionPlan = SubscriptionPlan::where('is_default', 1)->first();
        if (! empty($defaultSubscriptionPlan)) {
            $defaultSubscriptionPlan->update(['is_default' => 0]);
        }
        $subscriptionPlan = SubscriptionPlan::findOrFail($id);
        if ($subscriptionPlan->trial_days == 0) {
            $subscriptionPlan->trial_days = SubscriptionPlan::TRAIL_DAYS;
        }
        $subscriptionPlan->is_default = 1;
        $subscriptionPlan->save();

        return $this->sendSuccess(__('messages.success_message.default_plan_change'));
    }
}
