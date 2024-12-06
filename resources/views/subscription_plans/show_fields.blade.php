<div>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="poverview" role="tabpanel">
            <div class="card mb-5 mb-xl-10">
                <div>
                    <div class="card-body p-9">
                        <div class="row mb-7">
                            <div class="col-md-4 d-flex flex-column mb-md-10 mb-5">
                                {{ Form::label('name', __('messages.subscription_plan.name').(':'), ['class' => 'pb-2 fs-4 text-gray-600']) }}
                                <span class="fs-4 text-gray-800">{{ $subscriptionPlans->name }}</span>
                            </div>
                            <div class="col-md-4 d-flex flex-column mb-md-10 mb-5">
                                {{ Form::label('currency', __('messages.subscription_plan.currency').(':'), ['class' => 'pb-2 fs-4 text-gray-600']) }}
                                <span class="fs-4 text-gray-800">{{ strtoupper($subscriptionPlans->currency) }}</span>
                            </div>
                            <div class="col-md-4 d-flex flex-column mb-md-10 mb-5">
                                {{ Form::label('price', __('messages.subscription_plan.price').(':'), ['class' => 'pb-2 fs-4 text-gray-600']) }}
                                <span class="fs-4 text-gray-800">
                                    {{ getSubscriptionPlanCurrencyIcon($subscriptionPlans->currency) }} {{ number_format($subscriptionPlans->price) }}
                                </span>
                            </div>
                            <div class="col-md-4 d-flex flex-column mb-md-10 mb-5">
                                {{ Form::label('plan_type', __('messages.subscription_plan.plan_type').(':'), ['class' => 'pb-2 fs-4 text-gray-600']) }}
                                <p class="m-0">
                                    @if($subscriptionPlans->frequency == \App\Models\SubscriptionPlan::MONTH)
                                        <span class="badge fs-6 bg-light-info">{{ \App\Models\SubscriptionPlan::PLAN_TYPE[$subscriptionPlans->frequency] }}</span>
                                    @elseif($subscriptionPlans->frequency == \App\Models\SubscriptionPlan::YEAR)
                                        <span class="badge fs-6 bg-light-primary">{{ \App\Models\SubscriptionPlan::PLAN_TYPE[$subscriptionPlans->frequency] }}</span>
                                    @elseif ($subscriptionPlans->frequency == \App\Models\SubscriptionPlan::UNLIMITED)
                                        <span class="badge fs-6 bg-light-warning">{{ \App\Models\SubscriptionPlan::PLAN_TYPE[$subscriptionPlans->frequency] }}</span>
                                    @else
                                        {{ __('messages.common.n/a') }}
                                    @endif
                                </p>
                            </div>
                            <div class="col-md-4 d-flex flex-column mb-md-10 mb-5">
                                {{ Form::label('valid_until', __('messages.subscription_plan.valid_until').(':'), ['class' => 'pb-2 fs-4 text-gray-600']) }}
                                <span class="fs-4 text-gray-800">
                                    {{ $subscriptionPlans->trial_days != 0 ? $subscriptionPlans->trial_days : __('messages.common.n/a') }}
                                </span>
                            </div>
                            <div class="col-md-4 d-flex flex-column mb-md-10 mb-5">
                                {{ Form::label('active_plan', __('messages.subscription_plan.active_plan').(':'), ['class' => 'pb-2 fs-4 text-gray-600']) }}
                                <span class="fs-4 text-gray-800">
                                    {{ $subscriptionPlans->subscriptions->count() }}
                                </span>
                            </div>
                            <div class="col-md-4 d-flex flex-column mb-md-10 mb-5">
                                {{ Form::label('active_plan', __('messages.events').(':'), ['class' => 'pb-2 fs-4 text-gray-600']) }}
                                <span class="fs-4 text-gray-800">
                                    @if ($subscriptionPlans->planFeature->events == -1)
                                        {{__('messages.common.unlimited')}}
                                    @else
                                        {{$subscriptionPlans->planFeature->events }}
                                    @endif

                                </span>
                            </div>
                            <div class="col-md-4 d-flex flex-column mb-md-10 mb-5">
                                {{ Form::label('active_plan', __('messages.schedule_events').(':'), ['class' => 'pb-2 fs-4 text-gray-600']) }}
                                <span class="fs-4 text-gray-800">
                                    @if ($subscriptionPlans->planFeature->schedule_events == -1 )
                                        {{__('messages.common.unlimited')}}
                                    @else
                                        {{ $subscriptionPlans->planFeature->schedule_events }}
                                    @endif

                                </span>
                            </div>
                            <div class="col-md-4 d-flex flex-column mb-md-10 mb-5">
                                {{ Form::label('created_at', __('messages.common.created_on').(':'), ['class' => 'pb-2 fs-4 text-gray-600']) }}
                                <span class="fs-4 text-gray-800"
                                      title="{{\Carbon\Carbon::parse($subscriptionPlans->created_at)->translatedFormat('jS M Y')}}">{{ $subscriptionPlans->created_at->diffForHumans() }}</span>
                            </div>
                            <div class="col-md-4 d-flex flex-column mb-md-10 mb-5">
                                {{ Form::label('updated_at', __('messages.common.updated_at').(':'), ['class' => 'pb-2 fs-4 text-gray-600']) }}
                                <span class="fs-4 text-gray-800"
                                      title="{{\Carbon\Carbon::parse($subscriptionPlans->updated_at)->translatedFormat('jS M Y')}}">{{ $subscriptionPlans->updated_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
