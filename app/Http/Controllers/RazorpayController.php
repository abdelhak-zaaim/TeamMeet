<?php

namespace App\Http\Controllers;

use App\Models\SubscriptionPlan;
use App\Repositories\RazorpayRepository;
use App\Repositories\SubscriptionRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laracasts\Flash\Flash;
use Razorpay\Api\Api;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class RazorpayController extends AppBaseController
{
     /**
     * @var SubscriptionRepository
     */
    private $subscriptionRepo;

    /**
     * @var RazorpayRepository
     */
    private $razorpayRepo;

    public function __construct(SubscriptionRepository $subscriptionRepo, RazorpayRepository $razorpayRepo)
    {

        $this->subscriptionRepo = $subscriptionRepo;
        $this->razorpayRepo = $razorpayRepo;
    }
    public function onBoard(Request $request)
    {
        $input = $request->all();

        try {
            $subscriptionPlan = SubscriptionPlan::find($request->get('planId'));

            if ($subscriptionPlan->currency == null || !in_array(strtoupper($subscriptionPlan->currency),
            getRazorPaySupportedCurrencies())) {

                Flash::error(__('messages.error.razorpay_currency_not_supported'));

                return response()->json(['url' => route('subscription.pricing.plans.index')]);
            }


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

            $user = Auth::user();
            $api = new Api(getSuperAdminRazorpayKey(), getSuperAdminRazorpaySecretKey());
           
            $orderData = [
                'receipt' => $request->get('planId'),
                'amount' => $data['amountToPay'] * 100, // 100 = 1 rupees
                'currency' => strtoupper($data['plan']->currency),
                'notes' => [
                    'email' => $user->email,
                    'name' => $user->name,
                    'subscription_id' => $data['subscription']->id,
                    'amount' => $data['amountToPay'],
                ],
            ];

            $razorpayOrder = $api->order->create($orderData);
            $data['id'] = $razorpayOrder->id;
            $data['amount'] = $data['amountToPay'] * 100;
            $data['name'] = $user->name;
            $data['email'] = $user->email;
            $data['planID'] = $data['subscription']->id;

            return $this->sendResponse($data, __('messages.flash.order_created'));

        } catch (HttpException $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    /**
     * @return Application|Redirector|RedirectResponse
     */
    public function paymentSuccess(Request $request)
    {
        $input = $request->all();
        try {
            $subscription = $this->razorpayRepo->paymentSuccess($input);
            Flash::success($subscription->subscriptionPlan->name.' '.__('messages.subscription_pricing_plans.has_been_subscribed'));

            return redirect(route('subscription.pricing.plans.index'));

        }catch(Exception $e){
            Log::info('RazorPay Payment Failed Error:'.$e->getMessage());
            throw new UnprocessableEntityHttpException($e->getMessage());
        }

    }

     /**
     * @return Application|JsonResponse|RedirectResponse|Redirector
     */
    public function paymentFailed (Request $request)
    {
        try {
            $subscription = session('subscription_plan_id');

            $this->razorpayRepo->paymentFailed($subscription);

            Flash::error(__('messages.error.unable_to_process_the_payment'));

            return response()->json(['url' => route('subscription.pricing.plans.index')]);
        } catch (Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }
}
