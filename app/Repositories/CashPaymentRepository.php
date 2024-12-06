<?php

namespace App\Repositories;

use App\Models\Subscription;
use App\Models\UserTransaction;
use Exception;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

/**
 * Class CashPaymentRepository
 */
class CashPaymentRepository extends BaseRepository
{
    protected $fieldSearchable = [

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
        return UserTransaction::class;
    }

    public function cashPayData($input)
    {
        try {
            DB::beginTransaction();
            $subscriptionRepo = app()->make(SubscriptionRepository::class);
            $data = $subscriptionRepo->manageSubscription($input['plan_id']);

            if (! isset($data['plan'])) {
                if (isset($data['status']) && $data['status'] == true) {
                    throw new UnprocessableEntityHttpException($data['subscriptionPlan']->name.' '.__('messages.subscription_pricing_plans.has_been_subscribed'));
                } else {
                    if (isset($data['status']) && $data['status'] == false) {
                        throw new UnprocessableEntityHttpException(__('messages.flash.not_switch_to_zero_plan'));
                    }
                }
            }

            // If call returns body in response, you can get the deserialized version from the result attribute of the response
            $subscriptionId = $data['subscription']->id;
            $subscriptionAmount = $data['amountToPay'];

            //            Subscription::find($subscriptionId)->update(['status' => Subscription::ACTIVE]);
            //            // De-Active all other subscription
            //            Subscription::whereUserId(getLogInUserId())
            //                ->where('id', '!=', $subscriptionId)
            //                ->update([
            //                    'status' => Subscription::INACTIVE,
            //                ]);

            $userTransaction = UserTransaction::create([
                'transaction_id' => '',
                'payment_type' => UserTransaction::MANUALLY,
                'amount' => $subscriptionAmount,
                'user_id' => getLogInUserId(),
                'status' => Subscription::ACTIVE,
                'subscription_status' => UserTransaction::PENDING,
                'meta' => '',
                'note' => $input['note'],
            ]);

            if (isset($input['payment_attachment']) && ! empty($input['payment_attachment'])) {
                $userTransaction->addMedia($input['payment_attachment'])->toMediaCollection(UserTransaction::PAYMENT_ATTACHMENT,
                    config('app.media_disc'));
            }

            // updating the transaction id on the subscription table
            $subscription = Subscription::with('subscriptionPlan')->find($subscriptionId);
            $subscription->update(['transaction_id' => $userTransaction->id]);

            DB::commit();

            return $subscription;
        } catch (Exception $e) {
            DB::rollBack();

            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }
}
