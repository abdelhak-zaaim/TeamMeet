<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use App\Models\UserTransaction;
use App\Repositories\SubscriptionPlanRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Arr;
use Laracasts\Flash\Flash;

class SubscriptionPricingPlanController extends Controller
{
    private SubscriptionPlanRepository $subscriptionPlanRepository;

    public function __construct(SubscriptionPlanRepository $subscriptionPlanRepo)
    {
        $this->subscriptionPlanRepository = $subscriptionPlanRepo;
    }

    /**
     * @return Application|Factory|View
     */
    public function index(): \Illuminate\View\View
    {
        $data = $this->subscriptionPlanRepository->getSubscriptionPlansData();

        return view('subscription_pricing_plans.index')->with($data);
    }

    public function choosePaymentType($planId, $context = null, $fromScreen = null)
    {
        // code for checking the current plan is active or not, if active then it should not allow to choose that plan
        $subscription = getSubscription();

        if ($subscription->subscriptionPlan->id == $planId) {
            $toastData = [
                'toastType' => 'warning',
                'toastMessage' => $subscription->subscriptionPlan->name.' '.__('messages.subscription_pricing_plans.has_already_been_subscribed'),
            ];

            if ($context != null && $context == 'landing') {
                if ($fromScreen == 'landing.home') {
                    return redirect(route('landing.home'))->with('toast-data', $toastData);
                } elseif ($fromScreen == 'landing.about.us') {
                    return redirect(route('landing.about.us'))->with('toast-data', $toastData);
                } elseif ($fromScreen == 'landing.services') {
                    return redirect(route('landing.services'))->with('toast-data', $toastData);
                } elseif ($fromScreen == 'landing.pricing') {
                    return redirect(route('landing.pricing'))->with('toast-data', $toastData);
                }
            }
        }

        $subscriptionsPricingPlan = SubscriptionPlan::find($planId);
        $paymentTypes = Arr::except(Subscription::PAYMENT_TYPES, [Subscription::TYPE_FREE]);
        $paymentTypes = Arr::except($paymentTypes, 0);
        $userSetting = getUserSettingData(getLogInUserId());

        $userTransaction = UserTransaction::whereUserId(getLogInUserId())
            ->wherePaymentType(UserTransaction::MANUALLY)
            ->whereSubscriptionStatus(UserTransaction::PENDING)
            ->latest()->exists();

        if ($userTransaction) {
            Flash::error(__('messages.cash_payment.manual_transaction_requests_pending'));

            return redirect(route('subscription.pricing.plans.index'));
        }

        return view('subscription_pricing_plans.payment_for_plan', compact('subscriptionsPricingPlan', 'paymentTypes', 'userSetting'));
    }
}
