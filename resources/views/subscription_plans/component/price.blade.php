@if(!empty($row->price))
    <p class="mb-0">
        {{getSubscriptionPlanCurrencyIcon($row->currency).' '.number_format($row->price) }}
    </p>
@else
    {{__('messages.common.n/a')}}
@endif
