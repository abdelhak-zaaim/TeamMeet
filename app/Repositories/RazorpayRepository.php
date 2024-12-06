<?php

namespace App\Repositories;

use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use App\Models\UserTransaction;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Laracasts\Flash\Flash;
use Razorpay\Api\Api;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

/**
 * Class RazorpayRepository
 *
 * @version Dec 27, 2021, 12:51 pm UTC
 */
class RazorpayRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
        'stripe_id',
        'stripe_status',
        'stripe_plan',
        'subscription_plan_id',
        'transaction_id',
        'start_date',
        'end_date',
        'status',
    ];

    /**
     * {@inheritDoc}
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * {@inheritDoc}
     */
    public function model()
    {
        return Subscription::class;
    }



    public function paymentSuccess($input)
    {
        try {
            DB::beginTransaction();
            Log::info('RazorPay Payment Successfully');
            $api = new Api(getSuperAdminRazorpayKey(), getSuperAdminRazorpaySecretKey());

            if (count($input) && ! empty($input['razorpay_payment_id'])) {

                $payment = $api->payment->fetch($input['razorpay_payment_id']);
                $generatedSignature = hash_hmac('sha256', $payment['order_id'].'|'.$input['razorpay_payment_id'],
                getSuperAdminRazorpaySecretKey());

                if ($generatedSignature != $input['razorpay_signature']) {
                    return redirect()->back();
                }
                $subscriptionId = $payment['notes']['subscription_id'];
                $transactionID = $payment['id'];
                $amount = $payment['amount'];

                //Active Subscription
                $activeSubscription = Subscription::find($subscriptionId)->update(['status' => Subscription::ACTIVE]);

                // De-Active all other subscription
                $deactiveSubscription = Subscription::whereUserId(getLogInUserId())
                    ->where('id', '!=', $subscriptionId)
                    ->update([
                        'status' => Subscription::INACTIVE,
                    ]);

                // UserTransaction fot Subscription
                $transaction = UserTransaction::create([
                    'transaction_id' => $transactionID,
                    'payment_type' => UserTransaction::TYPE_RAZORPAY,
                    'amount' => $amount / 100,
                    'user_id' => getLogInUserId(),
                    'status' => Subscription::ACTIVE,
                    'meta' => json_encode($payment),
                ]);

                // Updating the transaction id on the subscription table
                $subscription = Subscription::find($subscriptionId);
                $subscription->update(['transaction_id' => $transaction->id]);

                DB::commit();

                return $subscription;
            }
        } catch (Exception $e) {
            DB::rollBack();
            Log::info('RazorPay Payment Failed Error:'.$e->getMessage());
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }


    public function paymentFailed($subscription)
    {
        $subscriptionPlan = Subscription::findOrFail($subscription);
        $subscriptionPlan->delete();

        return $subscriptionPlan;
    }
}
