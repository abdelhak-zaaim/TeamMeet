@extends('layouts.app')
@section('title')
    {{ __('messages.subscription_plan.payment_type') }}
@endsection
@section('content')
    <div class="container-fluid">
        @include('flash::message')
        <div class="d-flex flex-column">
            <div class="card">
                {{ Form::hidden('toast_data', session('toast-data'), ['id' => 'toastDataId']) }}
                <div class="card-header ms-auto border-0">
                    <div class="d-flex align-items-center py-0">
                        <a href="{{ route('subscription.pricing.plans.index') }}"
                            class="btn btn-outline-primary pull-right">{{ __('messages.common.back') }}</a>
                    </div>
                </div>
                @php
                    $cpData = getCurrentPlanDetails();
                    $planText = $cpData['isExpired']
                        ? __('messages.plans.current_expired_plan')
                        : __('messages.plans.current_plan');
                    $currentPlan = $cpData['currentPlan'];
                @endphp
                <div class="card-body p-lg-10">
                    <div class="row">
                        @if (currentActiveSubscription()->ends_at >= \Carbon\Carbon::now())
                            <div class="col-md-6 col-12 mb-md-0 mb-10">
                                <div class="card plan-card-shadow h-100 card-xxl-stretch p-5 me-md-2">
                                    <div class="card-header border-0 px-0">
                                        <h3 class="card-title align-items-start flex-column">
                                            <span class="card-label fw-bolder fs-1 mb-1 me-0">{{ $planText }}</span>
                                        </h3>
                                    </div>
                                    <div class="card-body py-3 px-0">
                                        <div class="flex-stack">
                                            <div class="d-flex align-items-center plan-border-bottom py-2">
                                                <h4 class="fs-5 w-50 mb-0 me-5 ">{{ __('messages.plans.plan_name') }}</h4>
                                                <span class="fs-5 w-50 text-muted fw-bold mt-1">{{ $cpData['name'] }}</span>
                                            </div>
                                            <div class="d-flex align-items-center plan-border-bottom py-2">
                                                <h4 class="fs-5 w-50 mb-0 me-3 ">{{ __('messages.plans.plan_price') }}</h4>
                                                <span class="fs-5 text-muted fw-bold mt-1">
                                                    <span class="mb-2">
                                                        {{ getSubscriptionPlanCurrencyIcon($currentPlan->currency) }}
                                                    </span>
                                                    {{ number_format($currentPlan->price) }}
                                                </span>
                                            </div>
                                            <div class="d-flex align-items-center plan-border-bottom py-2">
                                                <h4 class="fs-5 w-50 mb-0 me-5 ">{{ __('messages.plans.start_date') }}</h4>
                                                <span
                                                    class="fs-5 w-50 text-muted fw-bold mt-1">{{ $cpData['startAt'] }}</span>
                                            </div>
                                            <div class="d-flex align-items-center plan-border-bottom py-2">
                                                <h4 class="fs-5 w-50 mb-0 me-5 ">{{ __('messages.plans.end_date') }}</h4>
                                                <span
                                                    class="fs-5 w-50 text-muted fw-bold mt-1">{{ $cpData['endsAt'] }}</span>
                                            </div>
                                            <div class="d-flex align-items-center plan-border-bottom py-2">
                                                <h4 class="fs-5 w-50 mb-0 me-5 ">{{ __('messages.plans.used_days') }}</h4>
                                                <span class="fs-5 w-50 text-muted fw-bold mt-1">{{ $cpData['usedDays'] }}
                                                    {{ __('messages.plans.days') }}</span>
                                            </div>
                                            <div class="d-flex align-items-center plan-border-bottom py-2">
                                                <h4 class="fs-5 w-50 mb-0 me-5 ">{{ __('messages.plans.remaining_days') }}
                                                </h4>
                                                <span
                                                    class="fs-5 w-50 text-muted fw-bold mt-1">{{ $cpData['remainingDays'] }}
                                                    {{ __('messages.plans.days') }}</span>
                                            </div>
                                            <div class="d-flex align-items-center plan-border-bottom py-2">
                                                <h4 class="fs-5 w-50 mb-0 me-5 ">{{ __('messages.plans.used_balance') }}
                                                </h4>
                                                <span class="fs-5 w-50 text-muted fw-bold mt-1">
                                                    <span class="mb-2">
                                                        {{ getSubscriptionPlanCurrencyIcon($currentPlan->currency) }}
                                                    </span>
                                                    {{ $cpData['usedBalance'] }}
                                                </span>
                                            </div>
                                            <div class="d-flex align-items-center plan-border-bottom py-2">
                                                <h4 class="fs-5 w-50 mb-0 me-5 ">
                                                    {{ __('messages.plans.remaining_balance') }}</h4>
                                                <span class="fs-5 w-50 text-muted fw-bold mt-1">
                                                    <span
                                                        class="mb-2">{{ getSubscriptionPlanCurrencyIcon($currentPlan->currency) }}</span>
                                                    {{ $cpData['remainingBalance'] }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @php
                            $newPlan = getProratedPlanData($subscriptionsPricingPlan->id);
                        @endphp
                        <div class="col-md-6 col-12">
                            <div class="card plan-card-shadow h-100 card-xxl-stretch p-5 ms-md-2">
                                <div class="card-header border-0 px-0">
                                    <h3 class="card-title align-items-start flex-column">
                                        <span
                                            class="card-label fw-bolder fs-1 mb-1 me-0">{{ __('messages.plans.new_plan') }}</span>
                                    </h3>
                                </div>
                                <div class="card-body py-3 px-0">
                                    <div class="flex-stack">
                                        <div class="d-flex align-items-center plan-border-bottom py-2">
                                            <h4 class="fs-5 plan-data mb-0 me-5 ">{{ __('messages.plans.plan_name') }}</h4>
                                            <span class="fs-5 text-muted fw-bold mt-1">{{ $newPlan['name'] }}</span>
                                        </div>
                                        <div class="d-flex align-items-center plan-border-bottom py-2">
                                            <h4 class="fs-5 plan-data mb-0 me-5 ">{{ __('messages.plans.plan_price') }}
                                            </h4>
                                            <span class="fs-5 text-muted fw-bold mt-1">
                                                <span class="mb-2">
                                                    {{ getSubscriptionPlanCurrencyIcon($subscriptionsPricingPlan->currency) }}
                                                </span>
                                                {{ number_format($subscriptionsPricingPlan->price) }}
                                            </span>
                                        </div>
                                        <div class="d-flex align-items-center plan-border-bottom py-2">
                                            <h4 class="fs-5 plan-data mb-0 me-5 ">{{ __('messages.plans.start_date') }}
                                            </h4>
                                            <span class="fs-5 text-muted fw-bold mt-1">{{ $newPlan['startDate'] }}</span>
                                        </div>
                                        <div class="d-flex align-items-center plan-border-bottom py-2">
                                            <h4 class="fs-5 plan-data mb-0 me-5 ">{{ __('messages.plans.end_date') }}</h4>
                                            <span class="fs-5 text-muted fw-bold mt-1">{{ $newPlan['endDate'] }}</span>
                                        </div>
                                        <div class="d-flex align-items-center plan-border-bottom py-2">
                                            <h4 class="fs-5 plan-data mb-0 me-5 ">{{ __('messages.plans.total_days') }}
                                            </h4>
                                            <span class="fs-5 text-muted fw-bold mt-1">{{ $newPlan['totalDays'] }}
                                                {{ __('messages.plans.days') }}</span>
                                        </div>
                                        <div class="d-flex align-items-center plan-border-bottom py-2">
                                            <h4 class="fs-5 plan-data mb-0 me-5 ">
                                                {{ __('messages.plans.remaining_balance_of') }}</h4>
                                            <span class="fs-5 text-muted fw-bold mt-1">
                                                {{ getSubscriptionPlanCurrencyIcon($subscriptionsPricingPlan->currency) }}
                                                {{ $newPlan['remainingBalance'] }}
                                            </span>
                                        </div>
                                        <div class="d-flex align-items-center plan-border-bottom py-2">
                                            <h4 class="fs-5 plan-data mb-0 me-5 ">{{ __('messages.event.payable_amount') }}
                                            </h4>
                                            <span class="fs-5 text-muted fw-bold mt-1">
                                                {{ getSubscriptionPlanCurrencyIcon($subscriptionsPricingPlan->currency) }}
                                                {{ $newPlan['amountToPay'] }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if ($newPlan['amountToPay'] > 0)
                        <div class="row justify-content-center">
                            <div
                                class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 d-flex justify-content-center align-items-center mt-5 plan-controls">
                                <div class="mt-5 me-3 w-50 {{ $newPlan['amountToPay'] <= 0 ? 'd-none' : '' }}">
                                    {{-- {{ Form::select('payment_type', $paymentTypes, \App\Models\Subscription::TYPE_STRIPE, ['class' => 'form-select','required', 'id' => 'paymentType']) }} --}}
                                    {{ Form::select('payment_type', subscriptionPaymentTypes(), null, ['class' => 'form-select', 'required', 'id' => 'paymentType']) }}
                                </div>
                                @if (!empty(currentActiveSubscription()) && currentActiveSubscription()->ends_at >= \Carbon\Carbon::now())
                                    <div class="mt-5 stripePayment proceed-to-payment">
                                        <button type="button"
                                            class="btn btn-primary rounded-pill mx-auto d-block makePayment"
                                            data-id="{{ $subscriptionsPricingPlan->id }}"
                                            data-plan-price="{{ $subscriptionsPricingPlan->price }}">
                                            {{ __('messages.subscription_plan.pay_or_switch_plan') }}</button>
                                    </div>
                                    <div class="mt-5 paypalPayment proceed-to-payment d-none">
                                        <button type="button"
                                            class="btn btn-primary rounded-pill mx-auto d-block paymentByPaypal"
                                            data-id="{{ $subscriptionsPricingPlan->id }}"
                                            data-plan-price="{{ $subscriptionsPricingPlan->price }}">
                                            {{ __('messages.subscription_plan.pay_or_switch_plan') }}</button>
                                    </div>
                                    <div class="mt-5 cash-payment proceed-to-payment d-none">
                                        <button type="button"
                                            class="btn btn-primary rounded-pill mx-auto d-block payment-by-cash"
                                            data-id="{{ $subscriptionsPricingPlan->id }}"
                                            data-plan-price="{{ $subscriptionsPricingPlan->price }}">
                                            {{ __('messages.subscription_plan.pay_or_switch_plan') }}</button>
                                    </div>
                                    <div class="mt-5 paystackPayment proceed-to-payment d-none">
                                        <button type="button"
                                            class="btn btn-primary rounded-pill mx-auto d-block paymentByPaystack"
                                            data-id="{{ $subscriptionsPricingPlan->id }}"
                                            data-plan-price="{{ $subscriptionsPricingPlan->price }}">
                                        {{ __('messages.subscription_plan.pay_or_switch_plan') }}</button>
                                </div>
                                <div class="mt-5 razorpayPayment proceed-to-payment d-none">
                                    <button type="button"
                                            class="btn btn-primary rounded-pill mx-auto d-block paymentByRazorpay"
                                            data-id="{{ $subscriptionsPricingPlan->id }}"
                                            data-plan-price="{{ $subscriptionsPricingPlan->price }}">
                                            {{ __('messages.subscription_plan.pay_or_switch_plan') }}
                                    </button>
                                </div>
                            @else
                                <div class="mt-5 stripePayment proceed-to-payment">
                                    <button type="button"
                                            class="btn btn-primary rounded-pill mx-auto d-block makePayment"
                                            data-id="{{ $subscriptionsPricingPlan->id }}"
                                            data-plan-price="{{ $subscriptionsPricingPlan->price }}">
                                            {{ __('messages.web.choose_plan') }}</button>
                                    </div>
                                    <div class="mt-5 paypalPayment proceed-to-payment d-none">
                                        <button type="button"
                                            class="btn btn-primary rounded-pill mx-auto d-block paymentByPaypal"
                                            data-id="{{ $subscriptionsPricingPlan->id }}"
                                            data-plan-price="{{ $subscriptionsPricingPlan->price }}">
                                            {{ __('messages.web.choose_plan') }}</button>
                                    </div>
                                    <div class="mt-5 cash-payment proceed-to-payment d-none">
                                        <button type="button"
                                            class="btn btn-primary rounded-pill mx-auto d-block payment-by-cash"
                                            data-id="{{ $subscriptionsPricingPlan->id }}"
                                            data-plan-price="{{ $subscriptionsPricingPlan->price }}">
                                            {{ __('messages.subscription_plan.pay_or_switch_plan') }}</button>
                                    </div>
                                    <div class="mt-5 paystackPayment proceed-to-payment d-none">
                                        <button type="button"
                                            class="btn btn-primary rounded-pill mx-auto d-block paymentByPaystack"
                                            data-id="{{ $subscriptionsPricingPlan->id }}"
                                            data-plan-price="{{ $subscriptionsPricingPlan->price }}">

                                        {{ __('messages.web.choose_plan') }}</button>
                                </div>
                                <div class="mt-5 razorpayPayment proceed-to-payment d-none">
                                    <button type="button"
                                            class="btn btn-primary rounded-pill mx-auto d-block paymentByRazorpay"
                                            data-id="{{ $subscriptionsPricingPlan->id }}"
                                            data-plan-price="{{ $subscriptionsPricingPlan->price }}">
                                            {{ __('messages.web.choose_plan') }}
                                    </button>
                                </div>
                            @endif
                        </div>
                        <div class="row justify-content-center cash-payment-note d-none">
                            <div class="col-xl-4 col-lg-6 col-md-8 col-sm-12 col-12 mt-5">
                                {{ Form::label('attachment', __('messages.cash_payment.attachment') . ':', ['class' => 'form-label']) }}
                                <input id="paymentAttachment" class="form-control" name="payment_attachment"
                                    type="file">
                            </div>
                            <div class="col-xl-4 col-lg-6 col-md-8 col-sm-12 col-12 mt-5">
                                {{ Form::label('note', __('messages.cash_payment.note') . ':', ['class' => 'form-label']) }}
                                {{ Form::textarea('note', null, ['class' => 'form-control payment-note', 'rows' => 3]) }}
                            </div>
                        </div>
                    @else
                        <div class="mt-5 proceed-to-payment">
                            <button type="button"
                                class="btn btn-primary rounded-pill mx-auto d-block subscribePlanWithoutPrice"
                                data-id="{{ $subscriptionsPricingPlan->id }}"
                                data-plan-price="{{ $newPlan['amountToPay'] }}">
                                {{ __('messages.subscription_plan.pay_or_switch_plan') }}</button>
                        </div>
                    @endif
                    @php
                        if (
                            !empty(getSettingData()['stripe_checkbox_btn']) &&
                            getSettingData()['stripe_checkbox_btn'] == 1
                        ) {
                            $stripeKey = getSettingData()['stripe_key'];
                        } else {
                            $stripeKey = config('services.stripe.key');
                        }
                    @endphp
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="//js.stripe.com/v3/" data-turbo-eval="false"></script>
    <script data-turbo-eval="false">
        let stripe = Stripe('{{ $stripeKey }}')
    </script>
    <script src="https://checkout.razorpay.com/v1/checkout.js" data-turbolinks-eval="false" data-turbo-eval="false">
    </script>
    <script>
        let razorpayURL = "{{ route('admin.razorpay.init') }}"
        let razorpayFailed = "{{ route('admin.razorpay.failed') }}"
        // console.log("{{getSettingData()['application_name']}}");
        let options = {
            'key': "{{ getSuperAdminRazorpayKey() }}",
            'amount': 0,
            'currency' : 'INR',
            'name' : "{{getSettingData()['application_name']}}",
            'order_id': '',
            'description': '',
            'image': "{{ asset(getSettingData()['logo']) }}", // logo here
            'callback_url': "{{ route('admin.razorpay.success') }}",
            'prefill': {
                'email': '', // recipient email here
                'name': '', // recipient name here
            },
            'readonly': {
                'name': 'true',
                'email': 'true',
            },
            'modal': {
                'ondismiss': function() {
                    $.ajax({
                        type: 'POST',
                        url: razorpayFailed,
                        success: function(result) {
                            if (result.url) {
                                window.location.href = result.url
                            }
                        },
                        error: function(result) {
                            displayErrorMessage(result.responseJSON.message)
                        },
                    })
                },
            },
        }
    </script>
@endsection
