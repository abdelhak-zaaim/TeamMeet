<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use App\Models\UserTransaction;
use App\Repositories\SubscriptionRepository;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Laracasts\Flash\Flash;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Throwable;

class UserPaypalController extends AppBaseController
{
    /**
     * @var SubscriptionRepository
     */
    private $subscriptionRepository;

    /**
     * PaypalController constructor.
     */
    public function __construct(SubscriptionRepository $subscriptionRepository)
    {
        config([
            'paypal.mode' => ! empty(getSuperAdminPaypalMode()) ? getSuperAdminPaypalMode() : 'sandbox',
            'paypal.sandbox.client_id' => getSuperAdminPaypalClientID(),
            'paypal.sandbox.client_secret' => getSuperAdminPaypalClientSecret(),
            'paypal.live.client_id' => getSuperAdminPaypalClientID(),
            'paypal.live.client_secret' => getSuperAdminPaypalClientSecret(),
        ]);

        $this->subscriptionRepository = $subscriptionRepository;
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws Throwable
     */
    public function onBoard(Request $request): JsonResponse
    {
        if (empty(getSuperAdminPaypalClientID()) || empty(getSuperAdminPaypalClientSecret()) || empty(getSuperAdminPaypalMode())) {
            Flash::error(__('messages.success_message.paypal_credentials_not_found'));

            return response()->json(['url' => route('subscription.pricing.plans.index')]);
        }

        $subscriptionsPricingPlan = SubscriptionPlan::find($request->get('planId'));

        if ($subscriptionsPricingPlan->currency != null && ! in_array(strtoupper($subscriptionsPricingPlan->currency),
            getPayPalSupportedCurrencies())) {
            Flash::error(__('messages.success_message.currency_not_supported'));

            return response()->json(['url' => route('subscription.pricing.plans.index')]);
        }

        $data = $this->subscriptionRepository->manageSubscription($request->get('planId'));

        if (! isset($data['plan'])) { // 0 amount plan or try to switch the plan if it is in trial mode
            // returning from here if the plan is free.
            if (isset($data['status']) && $data['status'] == true) {
                return $this->sendSuccess($data['subscriptionPlan']->name.' '.__('messages.subscription_pricing_plans.has_been_subscribed'));
            } else {
                if (isset($data['status']) && $data['status'] == false) {
                    return $this->sendError(__('messages.error.plan_not_expire'));
                }
            }
        }

        try {
            $subscriptionsPricingPlan = $data['plan'];
            $subscription = $data['subscription'];
            $provider = new PayPalClient();
            $provider->getAccessToken();

            $data = [
                'intent' => 'CAPTURE',
                'purchase_units' => [
                    [
                        'reference_id' => $subscription->id,
                        'amount' => [
                            'value' => $data['amountToPay'],
                            'currency_code' => $subscriptionsPricingPlan->currency,
                        ],
                    ],
                ],
                'application_context' => [
                    'cancel_url' => route('user.paypal.failed'),
                    'return_url' => route('user.paypal.success'),
                ],
            ];

            $order = $provider->createOrder($data);
            session(['payment_type' => request()->get('payment_type')]);

            return response()->json($order);
        } catch (Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    /**
     * @return Application|RedirectResponse|Redirector
     */
    public function failed(): RedirectResponse
    {
        $subscription = session('subscription_plan_id');
        $subscriptionPlan = Subscription::find($subscription);
        $subscriptionPlan->delete();

        Flash::error(__('messages.success_message.unable_to_process'));

        $toastData = [
            'toastType' => 'error',
            'toastMessage' => 'Unable to process the payment at the moment. Try again later.',
        ];

        return redirect(route('subscription.pricing.plans.index'));
    }

    /**
     * @return Application|Redirector|RedirectResponse
     *
     * @throws Throwable
     */
    public function success(Request $request): RedirectResponse
    {
        $provider = new PayPalClient;
        $provider->getAccessToken();
        $token = $request->get('token');
        $orderInfo = $provider->showOrderDetails($token);

        try {
            // Call API with your client and get a response for your call
            $response = $provider->capturePaymentOrder($token);

            // If call returns body in response, you can get the deserialized version from the result attribute of the response
            $subscriptionId = $response['purchase_units'][0]['reference_id'];
            $subscriptionAmount = $response['purchase_units'][0]['payments']['captures'][0]['amount']['value'];
            $transactionID = $response['id'];     // $response->result->id gives the orderId of the order created above

            Subscription::find($subscriptionId)->update(['status' => Subscription::ACTIVE]);
            // De-Active all other subscription
            Subscription::whereUserId(getLogInUserId())
                ->where('id', '!=', $subscriptionId)
                ->update([
                    'status' => Subscription::INACTIVE,
                ]);

            $transaction = UserTransaction::create([
                'transaction_id' => $transactionID,
                'payment_type' => session('payment_type'),
                'amount' => $subscriptionAmount,
                'user_id' => getLogInUserId(),
                'status' => Subscription::ACTIVE,
                'meta' => json_encode($response),
            ]);

            // updating the transaction id on the subscription table
            $subscription = Subscription::find($subscriptionId);
            $subscription->update(['transaction_id' => $transaction->id]);

            Flash::success($subscription->subscriptionPlan->name.' '.__('messages.subscription_pricing_plans.has_been_subscribed'));

            $toastData = [
                'toastType' => 'success',
                'toastMessage' => $subscription->subscriptionPlan->name.' '.__('messages.subscription_pricing_plans.has_been_subscribed'),
            ];

            return redirect(route('subscription.pricing.plans.index'))->with('toast-data', $toastData);
        } catch (Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }
}
