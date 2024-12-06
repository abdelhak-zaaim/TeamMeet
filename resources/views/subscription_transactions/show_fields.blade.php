<div class="col-12">
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" role="tabpanel">
            <div class="card mb-5 mb-xl-10">
                <div class="card-body p-9">
                    <div class="row mb-7">
                        <label class="col-lg-4 fs-4 text-gray-600">{{ __('messages.subscription_plan.plan_name') }}</label>
                        <div class="col-lg-8 fv-row">
                            <span class="fs-4 text-gray-800">{{ $userTransaction->transactionSubscription->SubscriptionPlan->name }}</span>
                        </div>
                    </div>
                    <div class="row mb-7">
                        <label class="col-lg-4 fs-4 text-gray-600">{{ __('messages.subscription_plan.frequency') }}</label>
                        <div class="col-lg-8 fv-row">
                            <span class="fs-4 text-gray-800">{{ \App\Models\SubscriptionPlan::PLAN_TYPE[$userTransaction->transactionSubscription->plan_frequency] }}</span>
                        </div>
                    </div>
                    <div class="row mb-7">
                        <label class="col-lg-4 fs-4 text-gray-600">{{ __('messages.schedule_event.amount') }}</label>
                        <div class="col-lg-8 fv-row">
                            <span class="fs-4 text-gray-800">{{ getSubscriptionPlanCurrencyIcon($userTransaction->transactionSubscription->SubscriptionPlan->currency) }} {{ number_format($userTransaction->amount) }}</span>
                        </div>
                    </div>
                    <div class="row mb-7">
                        <label class="col-lg-4 fs-4 text-gray-600">{{ __('messages.schedule_event.date') }}</label>
                        <div class="col-lg-8 fv-row">
                            <span class="badge bg-light-info">{{ \Carbon\Carbon::parse($userTransaction->created_at)->translatedFormat('jS M, Y h:i A') }}</span>
                        </div>
                    </div>
                    <div class="row mb-7">
                        <label class="col-lg-4 fs-4 text-gray-600">{{ __('messages.schedule_event.payment_type') }}</label>
                        <div class="col-lg-8">
                            @if($userTransaction->payment_type == \App\Models\EventSchedule::STRIPE)
                                <span class="badge bg-light-success">{{
  \App\Models\EventSchedule::PAYMENT_METHOD[$userTransaction->payment_type] }}</span>
                            @else
                                <span class="badge bg-light-primary">{{ \App\Models\UserTransaction::PAYMENT_TYPES[$userTransaction->payment_type] }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-7">
                        <label class="col-lg-4 fs-4 text-gray-600">{{ __('messages.common.status') }}</label>
                        <div class="col-lg-8">
                            @if($userTransaction->status == 1)
                                <span class="badge bg-light-success">{{ __('messages.transaction.paid') }}</span>
                            @else
                                <span class="badge bg-light-danger">{{ __('messages.subscription_transaction.pending') }}</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

