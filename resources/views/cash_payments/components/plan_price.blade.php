@if(!empty($row->transactionSubscription->SubscriptionPlan))
    <div class="text-end">
        {{  getSubscriptionPlanCurrencyIcon($row->transactionSubscription->SubscriptionPlan->currency) }} {{ number_format($row->transactionSubscription->SubscriptionPlan->price)  }}
    </div>
@else
    <span>{{ __('messages.common.n/a') }}</span>
@endif
