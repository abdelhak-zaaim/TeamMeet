<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use App\Models\UserTransaction;
use App\Repositories\CashPaymentRepository;
use App\Repositories\SubscriptionRepository;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Laracasts\Flash\Flash;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class CashPaymentController extends AppBaseController
{
    /** @var CashPaymentRepository */
    private $cashPaymentRepo;

    public function __construct(CashPaymentRepository $cashPaymentRepository)
    {
        $this->cashPaymentRepo = $cashPaymentRepository;
    }

    /**
     * @return Application|Factory|View
     */
    public function index(): \Illuminate\View\View
    {
        return view('cash_payments.index');
    }

    public function cashPay(Request $request): JsonResponse
    {
        $input = $request->all();
        $subscription = $this->cashPaymentRepo->cashPayData($input);

        Flash::success($subscription->subscriptionPlan->name . ' ' . __('messages.subscription_pricing_plans.has_been_subscribed'));

        return response()->json([
            'toastType' => 'success',
            'url' => route('subscription.pricing.plans.index'),
        ]);
    }

    public function subscribePlan(Request $request)
    {
        $input = $request->all();

        try {
            DB::beginTransaction();

            $subscriptionPlan = SubscriptionPlan::find($input['plan_id']);
            // $newPlanDays = $subscriptionPlan->frequency == SubscriptionPlan::MONTH ? 30 : 365;
            $newPlanDays = ($subscriptionPlan->frequency == SubscriptionPlan::MONTH) ? 30 : (($subscriptionPlan->frequency == SubscriptionPlan::UNLIMITED) ? 36500 : 365);

            $startsAt = Carbon::now();
            $endsAt = $startsAt->copy()->addDays($newPlanDays);

            $input = [
                'user_id' => getLogInUser()->id,
                'subscription_plan_id' => $subscriptionPlan->id,
                'plan_amount' => $subscriptionPlan->price,
                'plan_frequency' => $subscriptionPlan->frequency,
                'starts_at' => $startsAt,
                'ends_at' => $endsAt,
                'status' => Subscription::ACTIVE,
            ];
            $subscription = Subscription::create($input);

            $input = $request->all();
            $subscriptionId = $subscription->id;
            $subscriptionAmount = $input['price'];

            Subscription::find($subscriptionId)->update(['status' => Subscription::ACTIVE]);
            // De-Active all other subscription
            Subscription::whereUserId(getLogInUserId())
                ->where('id', '!=', $subscriptionId)
                ->update([
                    'status' => Subscription::INACTIVE,
                ]);

            $userTransaction = UserTransaction::create([
                'transaction_id' => '',
                'payment_type' => UserTransaction::MANUALLY,
                'amount' => $subscriptionAmount,
                'user_id' => getLogInUserId(),
                'status' => Subscription::ACTIVE,
                'subscription_status' => UserTransaction::APPROVED,
                'meta' => '',
                'note' => '',
            ]);

            $subscription = Subscription::with('subscriptionPlan')->find($subscriptionId);
            $subscription->update(['transaction_id' => $userTransaction->id]);

            DB::commit();

            return response()->json([
                'toastType' => 'success',
                'url' => route('subscription.pricing.plans.index'),
            ]);
        } catch (Exception $e) {
            DB::rollBack();

            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    /**
     * @return mixed
     */
    public function downloadAttachment($mediaId)
    {
        $mediaItem = Media::find($mediaId);

        return $mediaItem;
    }
}
