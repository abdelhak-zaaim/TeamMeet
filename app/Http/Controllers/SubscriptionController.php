<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use App\Models\User;
use App\Models\UserTransaction;
use App\Repositories\CashPaymentRepository;
use App\Repositories\SubscriptionRepository;
use Carbon\Carbon;
use Exception;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Laracasts\Flash\Flash;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Stripe\Exception\ApiErrorException;

/**
 * Class SubscriptionController
 */
class SubscriptionController extends AppBaseController
{
    /**
     * @var SubscriptionRepository
     * @var CashPaymentRepository
     */
    private $subscriptionRepo;
    private $cashPaymentRepo;

    public function __construct(SubscriptionRepository $subscriptionRepo, CashPaymentRepository $cashPaymentRepository)
    {
        $this->subscriptionRepo = $subscriptionRepo;
        $this->cashPaymentRepo = $cashPaymentRepository;
    }

    /**
     * @return mixed
     *
     * @throws ApiErrorException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function purchaseSubscription(Request $request)
    {
        $input = $request->all();
        if($input['price'] == 0){
            $timeZoneName = isset(getLoginUser()->timezone) ?
            User::TIME_ZONE_ARRAY[getLoginUser()->timezone] : User::TIME_ZONE_ARRAY[getTimeZone()];
            date_default_timezone_set($timeZoneName);

        /** @var SubscriptionPlan $subscriptionPlan */
        $subscriptionPlan = SubscriptionPlan::find($input['plan_id']);
        // $newPlanDays = $subscriptionPlan->frequency == SubscriptionPlan::MONTH ? 30 : 365;
        $newPlanDays = ($subscriptionPlan->frequency == SubscriptionPlan::MONTH) ? 30 : (($subscriptionPlan->frequency == SubscriptionPlan::UNLIMITED) ? 36500 : 365);

        $startsAt = Carbon::now();
        $endsAt = $startsAt->copy()->addDays($newPlanDays);

        $usedTrialBefore = Subscription::whereUserId(getLogInUserId())->whereNotNull('trial_ends_at')->exists();

        // if the user did not have any trial plan then give them a trial
        if (! $usedTrialBefore && $subscriptionPlan->trial_days > 0) {
            $endsAt = $startsAt->copy()->addDays($subscriptionPlan->trial_days);
        }

        $amountToPay = $subscriptionPlan->price;

        /** @var Subscription $currentSubscription */
        $currentSubscription = currentActiveSubscription();

        $usedDays = Carbon::parse($currentSubscription->starts_at)->diffInDays($startsAt);
        $planIsInTrial = checkIfPlanIsInTrial($currentSubscription);
        // switching the plan -- Manage the pro-rating
        if (! $currentSubscription->isExpired() && $amountToPay != 0 && ! $planIsInTrial) {
            $usedDays = Carbon::parse($currentSubscription->starts_at)->diffInDays($startsAt);

            $currentPlan = $currentSubscription->subscriptionPlan; // TODO: take fields from subscription

            // checking if the current active subscription plan has the same price and frequency in order to process the calculation for the proration
            $planPrice = $currentPlan->price;
            $planFrequency = $currentPlan->frequency;
            if ($planPrice != $currentSubscription->plan_amount || $planFrequency != $currentSubscription->plan_frequency) {
                $planPrice = $currentSubscription->plan_amount;
                $planFrequency = $currentSubscription->plan_frequency;
            }

            // $frequencyDays = $planFrequency == SubscriptionPlan::MONTH ? 30 : 365;
            $frequencyDays = ($planFrequency == SubscriptionPlan::MONTH) ? 30 : (($planFrequency == SubscriptionPlan::UNLIMITED) ? 36500 : 365);

            $perDayPrice = round($planPrice / $frequencyDays, 2);

            $remainingBalance = $planPrice - ($perDayPrice * $usedDays);

            if ($remainingBalance < $subscriptionPlan->price) { // adjust the amount in plan i.e. you have to pay for it
                $amountToPay = round($subscriptionPlan->price - $remainingBalance, 2);
            } else {
                $perDayPriceOfNewPlan = round($subscriptionPlan->price / $newPlanDays, 2);

                if($perDayPriceOfNewPlan > 0){
                    $totalDays = round($remainingBalance / $perDayPriceOfNewPlan);
                }else{
                    $totalDays = round($remainingBalance);
                }

                $endsAt = Carbon::now()->addDays($totalDays);
                $amountToPay = 0;
            }
        }

        // check that if try to switch the plan
        if (! $currentSubscription->isExpired()) {
            if ((checkIfPlanIsInTrial($currentSubscription) || ! checkIfPlanIsInTrial($currentSubscription)) && $subscriptionPlan->price <= 0) {
                return ['status' => false, 'subscriptionPlan' => $subscriptionPlan];
            }
        }

        if ($usedDays <= 0) {
            $startsAt = $currentSubscription->starts_at;
        }

        $input = [
            'user_id' => getLogInUser()->id,
            'subscription_plan_id' => $subscriptionPlan->id,
            'plan_amount' => $subscriptionPlan->price,
            'plan_frequency' => $subscriptionPlan->frequency,
            'starts_at' => $startsAt,
            'ends_at' => $endsAt,
            'status' => Subscription::INACTIVE,
        ];

        $subscription = Subscription::create($input);

        if ($subscriptionPlan->price <= 0 || $amountToPay == 0) {
            // De-Active all other subscription
            Subscription::whereUserId(getLogInUserId())
            ->where('id', '!=', $subscription->id)
            ->update([
                'status' => Subscription::INACTIVE,
            ]);

            Subscription::findOrFail($subscription->id)->update(['status' => Subscription::ACTIVE]);

            // throw new UnprocessableEntityHttpException($data['subscriptionPlan']->name.' '.__('messages.subscription_pricing_plans.has_been_subscribed'));

            // If call returns body in response, you can get the deserialized version from the result attribute of the response
            $subscriptionId = $subscription->id;
            $subscriptionAmount = $amountToPay;

            $userTransaction = UserTransaction::create([
                'transaction_id' => '',
                'payment_type' => UserTransaction::MANUALLY,
                'amount' => $subscriptionAmount,
                'user_id' => getLogInUserId(),
                'status' => Subscription::ACTIVE,
                'subscription_status' => UserTransaction::APPROVED,
                'meta' => '',
            ]);

            // updating the transaction id on the subscription table
            $subscription = Subscription::with('subscriptionPlan')->find($subscriptionId);
            $subscription->update(['transaction_id' => $userTransaction->id]);
        }

            return response()->json([
                'toastType' => 'success',
                'message' => $subscription->subscriptionPlan->name.' '.__('messages.subscription_pricing_plans.has_been_subscribed'),
                'url' => route('subscription.pricing.plans.index'),
            ]);
        }

        if (empty(getSuperAdminStripeSecretKey())) {
            return $this->sendError('Please set stripe credentials');
        }

        $subscriptionPlanId = $request->get('plan_id');
        $result = $this->subscriptionRepo->purchaseSubscriptionForStripe($subscriptionPlanId);

        // returning from here if the plan is free.
        if (isset($result['status']) && $result['status'] == true) {
            return $this->sendSuccess($result['subscriptionPlan']->name.' '.__('messages.subscription_pricing_plans.has_been_subscribed'));
        } else {
            if (isset($result['status']) && $result['status'] == false) {
                return $this->sendError(__('messages.error.plan_not_expire'));
            }
        }

        return $this->sendResponse($result, __('messages.success_message.session_created_successfully'));
    }

    /**
     * @return Application|RedirectResponse|Redirector
     *
     * @throws ApiErrorException|Exception
     */
    public function userPaymentSuccess(Request $request): RedirectResponse
    {
        /** @var SubscriptionRepository $subscriptionRepo */
        $subscriptionRepo = app(SubscriptionRepository::class);
        $subscription = $subscriptionRepo->paymentUpdate($request);
        Flash::success($subscription->subscriptionPlan->name.' '.__('messages.subscription_pricing_plans.has_been_subscribed'));

        $toastData = [
            'toastType' => 'success',
            'toastMessage' => $subscription->subscriptionPlan->name.' '.__('messages.subscription_pricing_plans.has_been_subscribed'),
        ];

        return redirect(route('subscription.pricing.plans.index'));
    }

    /**
     * @return Application|RedirectResponse|Redirector
     */
    public function userHandleFailedPayment(): RedirectResponse
    {
        $subscriptionPlanId = session('subscription_plan_id');

        /** @var SubscriptionRepository $subscriptionRepo */
        $subscriptionRepo = app(SubscriptionRepository::class);
        $subscriptionRepo->paymentFailed($subscriptionPlanId);
        Flash::error(__('messages.success_message.unable_to_process'));

        $toastData = [
            'toastType' => 'error',
            'toastMessage' => __('messages.success_message.unable_to_process'),
        ];

        return redirect(route('subscription.pricing.plans.index'));
    }
}
