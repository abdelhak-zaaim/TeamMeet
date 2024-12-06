<?php

namespace App\Repositories;

use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use App\Models\User;
use App\Models\UserTransaction;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Stripe\Checkout\Session;
use Stripe\Exception\ApiErrorException;
use Stripe\Stripe;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

/**
 * Class SubscriptionRepository
 */
class SubscriptionRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'user_id',
        'stripe_id',
        'stripe_status',
        'stripe_plan',
        'subscription_plan_id',
        'start_date',
        'end_date',
        'status',
    ];

    /**
     * {@inheritDoc}
     */
    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    /**
     * {@inheritDoc}
     */
    public function model(): string
    {
        return Subscription::class;
    }

    /**
     * @throws ApiErrorException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function purchaseSubscriptionForStripe($subscriptionPlanId): array
    {
        $data = $this->manageSubscription($subscriptionPlanId);

        if (! isset($data['plan'])) { // 0 amount plan or try to switch the plan if it is in trial mode
            return $data;
        }

        $result = $this->manageStripeData(
            $data['plan'],
            ['amountToPay' => $data['amountToPay'], 'sub_id' => $data['subscription']->id]
        );

        return $result;
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function manageSubscription($subscriptionPlanId): array
    {
        $timeZoneName = isset(getLoginUser()->timezone) ?
            User::TIME_ZONE_ARRAY[getLoginUser()->timezone] : User::TIME_ZONE_ARRAY[getTimeZone()];
        date_default_timezone_set($timeZoneName);

        /** @var SubscriptionPlan $subscriptionPlan */
        $subscriptionPlan = SubscriptionPlan::find($subscriptionPlanId);
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

            return ['status' => true, 'subscriptionPlan' => $subscriptionPlan];
        }

        session(['subscription_plan_id' => $subscription->id]);
        session(['from_pricing' => request()->get('from_pricing')]);

        return [
            'plan' => $subscriptionPlan,
            'amountToPay' => $amountToPay,
            'subscription' => $subscription,
        ];
    }

    /**
     * @throws ApiErrorException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function manageStripeData($subscriptionPlan, $data): array
    {
        $amountToPay = $data['amountToPay'];
        $subscriptionID = $data['sub_id'];
        if ($subscriptionPlan->currency != null && in_array(getSubscriptionPlanCurrencyCode($subscriptionPlan->currency),
            zeroDecimalCurrencies())) {
            $planAmount = $amountToPay;
        } else {
            $planAmount = $amountToPay * 100;
        }

        Stripe::setApiKey(getSuperAdminStripeSecretKey());

        $session = Session::create([
            'payment_method_types' => ['card'],
            'customer_email' => getLogInUser()->email,
            'line_items' => [
                [
                    'price_data' => [
                        'product_data' => [
                            'name' => $subscriptionPlan->name,
                            'description' => 'Subscribing for the plan named '.$subscriptionPlan->name,
                        ],
                        'unit_amount' => $planAmount,
                        'currency' => $subscriptionPlan->currency,
                    ],
                    'quantity' => 1,
                ],
            ],
            'client_reference_id' => $subscriptionID,
            'metadata' => [
                'payment_type' => request()->get('payment_type'),
                'amount' => $planAmount,
                'plan_currency' => $subscriptionPlan->currency,
            ],
            'mode' => 'payment',
            'success_url' => url('user-payment-success').'?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => url('user-failed-payment?error=payment_cancelled'),
        ]);

        $result = [
            'sessionId' => $session['id'],
        ];

        return $result;
    }

    /**
     * @throws Exception
     */
    public function paymentUpdate($request)
    {
        $sessionId = $request->get('session_id');

        if (empty($sessionId)) {
            throw new UnprocessableEntityHttpException('session id not found.');
        }

        Stripe::setApiKey(getSuperAdminStripeSecretKey());

        $sessionData = Session::retrieve($sessionId);

        // where, $sessionData->client_reference_id = the subscription id
        Subscription::findOrFail($sessionData->client_reference_id)->update(['status' => Subscription::ACTIVE]);
        // De-Active all other subscription
        Subscription::whereUserId(getLogInUserId())
            ->where('id', '!=', $sessionData->client_reference_id)
            ->update([
                'status' => Subscription::INACTIVE,
            ]);

        if ($sessionData->metadata->plan_currency != null && in_array(getSubscriptionPlanCurrencyCode($sessionData->metadata->plan_currency),
            zeroDecimalCurrencies())) {
            $paymentAmount = $sessionData->amount_total;
        } else {
            $paymentAmount = $sessionData->amount_total / 100;
        }

        $transaction = UserTransaction::create([
            'transaction_id' => $request->session_id,
            'payment_type' => $sessionData->metadata->payment_type,
            'amount' => $paymentAmount,
            'user_id' => getLogInUserId(),
            'status' => Subscription::ACTIVE,
            'meta' => json_encode($sessionData),
        ]);

        $subscription = Subscription::findOrFail($sessionData->client_reference_id);
        $subscription->update(['transaction_id' => $transaction->id]);

        $subscription->load('subscriptionPlan');

        return $subscription;
    }

    public function paymentFailed($subscriptionPlanId)
    {
        $subscriptionPlan = Subscription::findOrFail($subscriptionPlanId);
        $subscriptionPlan->delete();
    }


    public function paystackSubscriptionSuccess($subscriptionId, $transactionId, $amount, $metaData)
    {
        try{
            Subscription::find($subscriptionId)->update(['status' => Subscription::ACTIVE]);
            Subscription::whereUserId(getLogInUserId())
            ->where('id', '!=', $subscriptionId)
            ->update([
                'status' => Subscription::INACTIVE,
            ]);

            $transaction = UserTransaction::create([
                'transaction_id' => $transactionId,
                'payment_type' => UserTransaction::TYPE_PAYSTACK,
                'amount' => $amount,
                'user_id' => getLogInUserId(),
                'status' => Subscription::ACTIVE,
                'meta' => json_encode($metaData),
            ]);

            $subscription = Subscription::find($subscriptionId);
            $subscription->update(['transaction_id' => $transaction->id]);


            return  $subscription;

        }catch(Exception $e){
            DB::rollBack();

            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }
}
