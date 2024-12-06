<?php

namespace App\Http\Controllers;

use App;
use App\Models\EventSchedule;
use App\Models\SubscriptionPlan;
use App\Models\Transaction;
use App\Models\User;
use App\Repositories\ScheduleEventRepository;
use App\Repositories\SubscriptionRepository;
use Exception;
use Flash;
use Illuminate\Http\Request;
use Unicodeveloper\Paystack\Facades\Paystack;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class PaystackController extends AppBaseController
{
    /**
     * @var SubscriptionRepository
     */
    private $subscriptionRepo;

    public function __construct(SubscriptionRepository $subscriptionRepo)
    {

        $this->subscriptionRepo = $subscriptionRepo;
    }

    public function redirectToGateway(Request $request)
    {
        // $this->userPaystackConfig();
        $supportedCurrencies = ['NGN', 'GHS', 'KES', 'ZAR', 'UGX'];
        // $supportedCurrencies = ['GHS'];
        $currentCurrency = strtoupper(getCurrentCurrency());

        // pay schedule event payment caode
        if(!empty($request->get('scheduleEventId'))) {

            if (!in_array($currentCurrency, $supportedCurrencies)) {
                Flash::error(__('messages.error.currency_not_supported'));
                $scheduleEvent = EventSchedule::findOrFail($request->get('scheduleEventId'));
                $scheduleEvent->delete();
                return response()->json(['url' => route('events.index')]);
            }

            $scheduleEvent = EventSchedule::findOrFail($request->get('scheduleEventId'));
            $userId = $scheduleEvent->user_id;

            if (empty(getPayStackPublicKey($userId)) || empty(getPayStackSecretKey($userId))) {
                Flash::error(__('messages.error.paystack_credentials_not_found'));

                return response()->json(['url' => route('events.index')]);
            }

            $publicKey = getPayStackPublicKey($userId);
            $secretKey = getPayStackSecretKey($userId);

            config([
                'paystack.publicKey' => $publicKey,
                'paystack.secretKey' => $secretKey,
            ]);

            try {
                $request->merge([
                    'email' => getLogInUser()->email,
                    'orderID' => $scheduleEvent->id,
                    'amount' => ($scheduleEvent->event->payable_amount * 100),
                    'quantity' => 1,
                    'currency' => strtoupper(getCurrentCurrency()),
                    'reference' => Paystack::genTranxRef(),
                    'metadata' => json_encode(['schedule_event_id' => $scheduleEvent->id]),
                ]);

                $authorizationUrl = Paystack::getAuthorizationUrl();

                return $this->sendResponse($authorizationUrl, __('messages.success_message.retrieved_successfully'));

            } catch (Exception $e) {
                if(!empty($request->get('scheduleEventId'))){
                    $scheduleEvent = EventSchedule::findOrFail($request->get('scheduleEventId'));
                    $scheduleEvent->delete();
                }
                Flash::error(__('messages.error.payment_not_completed'));

                return redirect()->back()->withMessage([
                    'msg' => __('messages.error.paystack_token_has_expired'), 'type' => 'error',
                ]);
            }
        //Paystack for Subscription
        }elseif(!empty($request->get('planId'))) {

            $subscriptionsPricingPlan = SubscriptionPlan::findOrFail($request->get('planId'));

            if ($subscriptionsPricingPlan->currency == null || !in_array(strtoupper($subscriptionsPricingPlan->currency),
            $supportedCurrencies)) {
                Flash::error(__('messages.error.currency_not_supported'));
                return response()->json(['url' => route('subscription.pricing.plans.index')]);
            }

            if (empty(getPaymentCredentials('paystack_secret')) || empty(getPaymentCredentials('paystack_secret'))) {
                Flash::error(__('messages.error.paystack_credentials_not_found'));

                return response()->json(['url' => route('subscription.pricing.plans.index')]);
            }

            $publicKey = getPaymentCredentials('paystack_key');
            $secretKey = getPaymentCredentials('paystack_secret');

            config([
                'paystack.publicKey' => $publicKey,
                'paystack.secretKey' => $secretKey,

            ]);

            $data = $this->subscriptionRepo->manageSubscription($request->get('planId'));

            if (! isset($data['plan'])) {
                if (isset($data['status']) && $data['status'] == true) {
                    return $this->sendSuccess($data['subscriptionPlan']->name.' '.__('messages.subscription_pricing_plans.has_been_subscribed'));
                } else {
                    if (isset($data['status']) && $data['status'] == false) {
                        return $this->sendError(__('messages.error.plan_not_expire'));
                    }
                }
            }

            try {
                $request->merge([
                    'email' =>  getLogInUser()->email,
                    'orderID' => rand(10000, 99999),
                    'amount' => $data['amountToPay'] * 100,
                    'quantity' => 1, // always 1
                    'currency' => strtoupper(getCurrentCurrency()),
                    'reference' => Paystack::genTranxRef(),
                    'metadata' => json_encode(['subscription_id' => $data['subscription']->id, 'planId' => $data['plan']->id]), // this should be related data
                ]);

                $authorizationUrl = Paystack::getAuthorizationUrl();

                return $this->sendResponse($authorizationUrl, __('messages.success_message.retrieved_successfully'));
            } catch (Exception $e) {
                throw new UnprocessableEntityHttpException($e->getMessage());
            }

        }else {
            return redirect()->back()->withMessage([
                'msg' => __('messages.error.paystack_token_has_expired'), 'type' => 'error',
            ]);
        }

    }

    public function payStackPaymentSuccess(Request $request)
    {
        $userId  = getLogInUserId();
        $publicKey = getPayStackPublicKey($userId);
        $secretKey = getPayStackSecretKey($userId);

        config([
            'paystack.publicKey' => $publicKey,
            'paystack.secretKey' => $secretKey,
        ]);

        $paymentDetails = Paystack::getPaymentData();

        try {
                $scheduleEvent = EventSchedule::find($paymentDetails['data']['metadata']['schedule_event_id']);
                $user = User::find($scheduleEvent->user_id);

                $transaction = [
                    'user_id' => $user->id,
                    'transaction_id' => $paymentDetails['data']['id'],
                    'schedule_event_id' => $paymentDetails['data']['metadata']['schedule_event_id'],
                    'amount' => ($paymentDetails['data']['amount'] / 100),
                    'type' => \App\Models\EventSchedule::PAYSTACK,
                    'meta' => json_encode($paymentDetails),
                ];

                Transaction::create($transaction);
                $scheduleEvent->update(['status' => EventSchedule::BOOKED]);
                $redirectUrl = getSlotConfirmPageUrl($scheduleEvent);

                $scheduleEventRepo = App::make(ScheduleEventRepository::class);
                $scheduleEventRepo->scheduleEventMails($scheduleEvent, $scheduleEvent->email, true);

                Flash::success('Schedule Event created successfully and Payment is completed.');

                return redirect(url($redirectUrl));
        } catch (Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    public function subscriptionPaystackSuccess(Request $request)
    {
        $publicKey = getPaymentCredentials('paystack_key');
        $secretKey = getPaymentCredentials('paystack_secret');

        config([
            'paystack.publicKey' => $publicKey,
            'paystack.secretKey' => $secretKey,

        ]);

        $paymentDetails = Paystack::getPaymentData();

        try {
            $subscriptionId = $paymentDetails['data']['metadata']['subscription_id'];
            $transactionId = $paymentDetails['data']['reference'];
            $amount = $paymentDetails['data']['amount'] / 100;
            $metaData = json_encode($paymentDetails['data']);

            $subscription = $this->subscriptionRepo->paystackSubscriptionSuccess($subscriptionId, $transactionId, $amount, $metaData);

            Flash::success($subscription->subscriptionPlan->name.' '.__('messages.subscription_pricing_plans.has_been_subscribed'));

            return redirect(route('subscription.pricing.plans.index'));

        } catch (Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }
}
