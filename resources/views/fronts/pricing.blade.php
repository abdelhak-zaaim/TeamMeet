@extends('fronts.layouts.app')
@section('front-title')
    {{ __('messages.pricing') }}
@endsection
@section('front-css')
    <link href="{{ asset('front/css/pricing.css') }}" rel="stylesheet" type="text/css">
    <style>
        ul li::before {
            content: none !important;
        }
    </style>
@endsection
@section('front-content')
    <div class="pricing-page">
        <!-- start budget section -->
        <section class="budget-section p-t-100 p-b-100 padding-top-0">
            <div class="container">
                <div class="col-12 text-center">
                    <div class="hero-content mt-5 mt-lg-0">
                        <h1 class="mb-3 pb-1 max-w-620 mx-auto">
                            {{ __('messages.web.choose_package_match_your_budget') }}
                        </h1>
                        <ul class="d-flex ps-0 mb-5 pb-2 justify-content-center flex-wrap">
                            <li class="mb-2">{{ __('messages.5_minute_installation') }}</li>
                            <li class="mb-2">{{ __('messages.try_team_plan') }}</li>
                            <li class="mb-2">{{ __('messages.no_credit_card') }}</li>
                        </ul>

                        {{-- <div class="switches-container">
                            <input type="radio" id="switchMonthly" name="switchPlan" value="Monthly" checked="checked" data-toggle="tab" href="#month">
                            <input type="radio" id="switchYearly" name="switchPlan" value="Yearly" data-toggle="tab" href="#year">
                            <label for="switchMonthly">{{__('messages.monthly')}}</label>
                            <label for="switchYearly">{{__('messages.yearly')}}</label>
                            <div class="switch-wrapper">
                                <div class="switch">
                                    <div>{{__('messages.monthly')}}</div>
                                    <div>{{__('messages.yearly')}}</div>
                                </div>
                            </div>
                        </div> --}}

                        <div class="justify-content-center d-flex">
                            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="month-tab" data-bs-toggle="pill"
                                        data-bs-target="#month" type="button" role="tab" aria-controls="pills-month"
                                        aria-selected="true">{{ __('messages.common.month') }}
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="year-tab" data-bs-toggle="pill" data-bs-target="#year"
                                        type="button" role="tab" aria-controls="pills-year"
                                        aria-selected="false">{{ __('messages.common.year') }}
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="unlimited-tab" data-bs-toggle="pill"
                                        data-bs-target="#unlimited" type="button" role="tab"
                                        aria-controls="pills-unlimited"
                                        aria-selected="false">{{ __('messages.common.unlimited') }}
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- end budget section -->

        <!-- start pricing plan section -->
        <section class="pricing-plan-section bg-light p-t-100 p-b-100">
            <div class="container">
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="month" role="tabpanel" aria-labelledby="pills-month-tab">
                        <div class="row justify-content-center">
                            @foreach ($subscriptionPricingMonthPlans as $key => $subscriptionPricingMonthPlan)
                                <div class="col-xxl-4 col-md-6 pricing-plan-block d-flex align-items-stretch pt-3 pb-3">
                                    <div class="card border-0 mx-lg-2 flex-fill rounded-20">
                                        <div class="card-header text-center">
                                            <h3 class="text-white fs-4 mb-3">{{ $subscriptionPricingMonthPlan->name }}</h4>
                                                <h4 class="text-white fs-1 mb-0">
                                                    {{ getSubscriptionPlanCurrencyIcon($subscriptionPricingMonthPlan->currency) }}
                                                    {{ number_format($subscriptionPricingMonthPlan->price) }}
                                            </h3>
                                        </div>
                                        <div class="card-body d-flex flex-column">
                                            <ul class="list-unstyled mb-5">
                                                <li class="d-flex align-itmes-center text-secondary">
                                                    <span class="check-box me-3">
                                                        <i class="fa-solid fa-check text-primary"></i>
                                                    </span>
                                                    {{ __('messages.subscription_plan.events') }} :
                                                    {{ $subscriptionPricingMonthPlan->planFeature->events }}
                                                </li>
                                                <li class="d-flex align-itmes-center text-secondary">
                                                    <span class="check-box me-3">
                                                        <i class="fa-solid fa-check text-primary"></i>
                                                    </span>
                                                    {{ __('messages.event.schedule_event') }} :
                                                    {{ $subscriptionPricingMonthPlan->planFeature->schedule_events }}
                                                </li>
                                            </ul>
                                            @if (Auth::check())
                                                <a href="{{ getLogInUser()->hasRole('user') ? route('subscription.pricing.plans.index') : route('admin.dashboard') }}"
                                                    class="btn btn-outline-primary mt-auto "
                                                    data-turbo="false">{{ __('messages.web.choose_plan') }}</a>
                                            @else
                                                <a href="{{ route('login') }}" class="btn btn-outline-primary mt-auto"
                                                    data-turbo="false">{{ __('messages.web.choose_plan') }}</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show d-none" id="year" role="tabpanel" aria-labelledby="year-tab">
                        <div class="row justify-content-center">
                            @foreach ($subscriptionPricingYearPlans as $key => $subscriptionPricingYearPlans)
                                <div class="col-xxl-4 col-md-6 pricing-plan-block d-flex align-items-stretch pt-3 pb-3">
                                    <div class="card border-0 mx-lg-2 flex-fill rounded-20">
                                        <div class="card-header text-center">
                                            <h3 class="text-white fs-4 mb-3">{{ $subscriptionPricingYearPlans->name }}</h4>
                                                <h4 class="text-white fs-1 mb-0">
                                                    {{ getSubscriptionPlanCurrencyIcon($subscriptionPricingYearPlans->currency) }}
                                                    {{ number_format($subscriptionPricingYearPlans->price) }}
                                            </h3>
                                        </div>
                                        <div class="card-body d-flex flex-column">
                                            <ul class="list-unstyled mb-5">
                                                <li class="d-flex align-itmes-center text-secondary">
                                                    <span class="check-box me-3">
                                                        <i class="fa-solid fa-check text-primary"></i>
                                                    </span>
                                                    {{ __('messages.subscription_plan.events') }} :
                                                    {{ $subscriptionPricingYearPlans->planFeature->events }}
                                                </li>
                                                <li class="d-flex align-itmes-center text-secondary">
                                                    <span class="check-box me-3">
                                                        <i class="fa-solid fa-check text-primary"></i>
                                                    </span>
                                                    {{ __('messages.event.schedule_event') }} :
                                                    {{ $subscriptionPricingYearPlans->planFeature->schedule_events }}
                                                </li>
                                            </ul>
                                            @if (Auth::check())
                                                <a href="{{ getLogInUser()->hasRole('user') ? route('subscription.pricing.plans.index') : route('admin.dashboard') }}"
                                                    class="btn btn-outline-primary mt-auto"
                                                    data-turbo="false">{{ __('messages.web.choose_plan') }}</a>
                                            @else
                                                <a href="{{ route('login') }}" class="btn btn-outline-primary mt-auto"
                                                    data-turbo="false">{{ __('messages.web.choose_plan') }}</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show d-none" id="unlimited" role="tabpanel" aria-labelledby="unlimited-tab">
                        <div class="row justify-content-center">
                            @foreach ($subscriptionPricingUnlimitedPlans as $key => $subscriptionPricingUnlimitedPlan)
                                <div class="col-xxl-4 col-md-6 pricing-plan-block d-flex align-items-stretch pt-3 pb-3">
                                    <div class="card border-0 mx-lg-2 flex-fill rounded-20">
                                        <div class="card-header text-center">
                                            <h3 class="text-white fs-4 mb-3">{{ $subscriptionPricingUnlimitedPlan->name }}</h4>
                                                <h4 class="text-white fs-1 mb-0">
                                                    {{ getSubscriptionPlanCurrencyIcon($subscriptionPricingUnlimitedPlan->currency) }}
                                                    {{ number_format($subscriptionPricingUnlimitedPlan->price) }}
                                            </h3>
                                        </div>
                                        <div class="card-body d-flex flex-column">
                                            <ul class="list-unstyled mb-5">
                                                <li class="d-flex align-itmes-center text-secondary">
                                                    <span class="check-box me-3">
                                                        <i class="fa-solid fa-check text-primary"></i>
                                                    </span>
                                                    {{ __('messages.subscription_plan.events') }} :
                                                    {{ $subscriptionPricingUnlimitedPlan->planFeature->events }}
                                                </li>
                                                <li class="d-flex align-itmes-center text-secondary">
                                                    <span class="check-box me-3">
                                                        <i class="fa-solid fa-check text-primary"></i>
                                                    </span>
                                                    {{ __('messages.event.schedule_event') }} :
                                                    {{ $subscriptionPricingUnlimitedPlan->planFeature->schedule_events }}
                                                </li>
                                            </ul>
                                            @if (Auth::check())
                                                <a href="{{ getLogInUser()->hasRole('user') ? route('subscription.pricing.plans.index') : route('admin.dashboard') }}"
                                                    class="btn btn-outline-primary mt-auto"
                                                    data-turbo="false">{{ __('messages.web.choose_plan') }}</a>
                                            @else
                                                <a href="{{ route('login') }}" class="btn btn-outline-primary mt-auto"
                                                    data-turbo="false">{{ __('messages.web.choose_plan') }}</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>


                {{-- <div class="row justify-content-center" id="month">
                    @foreach ($subscriptionPricingMonthPlans as $key => $subscriptionPricingMonthPlan)
                        <div class="col-xxl-4 col-md-6 pricing-plan-block d-flex align-items-stretch pt-3 pb-3">
                            <div class="card border-0 mx-lg-2 flex-fill rounded-20">
                                <div class="card-header text-center">
                                    <h3 class="text-white fs-4 mb-3">{{ $subscriptionPricingMonthPlan->name }}</h4>
                                        <h4 class="text-white fs-1 mb-0">
                                            {{ getSubscriptionPlanCurrencyIcon($subscriptionPricingMonthPlan->currency) }}
                                            {{ number_format($subscriptionPricingMonthPlan->price) }}
                                    </h3>
                                </div>
                                <div class="card-body d-flex flex-column">
                                    <ul class="list-unstyled mb-5">
                                        <li class="d-flex align-itmes-center text-secondary">
                                            <span class="check-box me-3">
                                                <i class="fa-solid fa-check text-primary"></i>
                                            </span>
                                            {{ __('messages.subscription_plan.events') }} :
                                            {{ $subscriptionPricingMonthPlan->planFeature->events }}
                                        </li>
                                        <li class="d-flex align-itmes-center text-secondary">
                                            <span class="check-box me-3">
                                                <i class="fa-solid fa-check text-primary"></i>
                                            </span>
                                            {{ __('messages.event.schedule_event') }} :
                                            {{ $subscriptionPricingMonthPlan->planFeature->schedule_events }}
                                        </li>
                                    </ul>
                                    @if (Auth::check())
                                        <a href="{{ getLogInUser()->hasRole('user') ? route('subscription.pricing.plans.index') : route('admin.dashboard') }}"
                                            class="btn btn-outline-primary mt-auto "
                                            data-turbo="false">{{ __('messages.web.choose_plan') }}</a>
                                    @else
                                        <a href="{{ route('login') }}" class="btn btn-outline-primary mt-auto"
                                            data-turbo="false">{{ __('messages.web.choose_plan') }}</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="row justify-content-center d-none" id="year">
                    @foreach ($subscriptionPricingYearPlans as $key => $subscriptionPricingYearPlans)
                        <div class="col-xxl-4 col-md-6 pricing-plan-block d-flex align-items-stretch pt-3 pb-3">
                            <div class="card border-0 mx-lg-2 flex-fill rounded-20">
                                <div class="card-header text-center">
                                    <h3 class="text-white fs-4 mb-3">{{ $subscriptionPricingYearPlans->name }}</h4>
                                        <h4 class="text-white fs-1 mb-0">
                                            {{ getSubscriptionPlanCurrencyIcon($subscriptionPricingYearPlans->currency) }}
                                            {{ number_format($subscriptionPricingYearPlans->price) }}
                                    </h3>
                                </div>
                                <div class="card-body d-flex flex-column">
                                    <ul class="list-unstyled mb-5">
                                        <li class="d-flex align-itmes-center text-secondary">
                                            <span class="check-box me-3">
                                                <i class="fa-solid fa-check text-primary"></i>
                                            </span>
                                            {{ __('messages.subscription_plan.events') }} :
                                            {{ $subscriptionPricingYearPlans->planFeature->events }}
                                        </li>
                                        <li class="d-flex align-itmes-center text-secondary">
                                            <span class="check-box me-3">
                                                <i class="fa-solid fa-check text-primary"></i>
                                            </span>
                                            {{ __('messages.event.schedule_event') }} :
                                            {{ $subscriptionPricingYearPlans->planFeature->schedule_events }}
                                        </li>
                                    </ul>
                                    @if (Auth::check())
                                        <a href="{{ getLogInUser()->hasRole('user') ? route('subscription.pricing.plans.index') : route('admin.dashboard') }}"
                                            class="btn btn-outline-primary mt-auto"
                                            data-turbo="false">{{ __('messages.web.choose_plan') }}</a>
                                    @else
                                        <a href="{{ route('login') }}" class="btn btn-outline-primary mt-auto"
                                            data-turbo="false">{{ __('messages.web.choose_plan') }}</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div> --}}
            </div>
        </section>
        <!-- end pricing plan section -->

        <!-- start counts section -->
        <section class="counts-section bg-primary p-t-100 p-b-100">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-4 col-sm-6">
                        <div class="d-lg-flex text-center text-lg-start">
                            <div class="count-icon d-flex align-items-center justify-content-center">
                                <img src="{{ asset('front/images/registere-user.png') }}" alt="" loading="lazy">
                            </div>
                            <div class="ms-lg-4 ps-xxl-3">
                                <h3 class="fs-2 text-white fw-bolder">{{ $data['registeredUsersCount'] }}</h3>
                                <h4 class="text-white mb-0 fw-light">{{ __('messages.web.registered_users') }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6 mt-sm-0 mt-4">
                        <div class="d-lg-flex text-center text-lg-start">
                            <div class="count-icon d-flex align-items-center justify-content-center">
                                <img src="{{ asset('front/images/events-created.png') }}" alt="Events Created" loading="lazy">
                            </div>
                            <div class="ms-lg-4 ps-xxl-3">
                                <h3 class="fs-2 text-white fw-bolder">{{ $data['eventsCreatedCount'] }}</h3>
                                <h4 class="text-white mb-0 fw-light">{{ __('messages.web.events_created') }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6 mt-lg-0 mt-4 pt-lg-0 pt-md-3">
                        <div class="d-lg-flex text-center text-lg-start">
                            <div class="count-icon d-flex align-items-center justify-content-center">
                                <img src="{{ asset('front/images/scheduled-events.png') }}" alt="Scheduled Events" loading="lazy">
                            </div>
                            <div class="ms-lg-4 ps-xxl-3">
                                <h3 class="fs-2 text-white fw-bolder">{{ $data['scheduledEventsCount'] }}</h3>
                                <h4 class="text-white mb-0 fw-light">{{ __('messages.web.scheduled_events') }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endsection
