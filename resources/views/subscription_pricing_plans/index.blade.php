@extends('layouts.app')
@section('title')
    {{__('messages.subscription_plan.subscription_plans')}}
@endsection
@section('content')
    <div class="container-fluid">
        @include('flash::message')
        <div class="d-flex flex-column">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-column">
                        <div class="d-flex align-items-center justify-content-center">
                            @include('subscription_pricing_plans.pricing_plan_button')
                        </div>
                        <div class="row">
                            <div class="card-body">
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="pills-month" role="tabpanel"
                                         aria-labelledby="pills-month-tab">
                                        <div class="row justify-content-center">
                                            @forelse($subscriptionPricingMonthPlans as $subscriptionsPricingPlan)
                                                @include('subscription_pricing_plans.pricing_plan_section')
                                            @empty
                                                <div class="col-lg-4 col-md-6">
                                                    <div class="card text-center empty_featured_card">
                                                        <div class="card-body d-flex align-items-center justify-content-center">
                                                            <div>
                                                                <div class="empty-featured-portfolio">
                                                                    <i class="fas fa-question"></i>
                                                                </div>
                                                                <h3 class="card-title mt-3">
                                                                    {{ __('messages.subscription_month_plan_not_found') }}
                                                                </h3>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforelse
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="pills-year" role="tabpanel"
                                         aria-labelledby="pills-year-tab">
                                        <div class="row justify-content-center">
                                            @forelse($subscriptionPricingYearPlans as $subscriptionsPricingPlan)
                                                @include('subscription_pricing_plans.pricing_plan_section')
                                            @empty
                                                <div class="col-lg-4 col-md-6">
                                                    <div class="card text-center empty_featured_card">
                                                        <div class="card-body d-flex align-items-center justify-content-center">
                                                            <div>
                                                                <div class="empty-featured-portfolio">
                                                                    <i class="fas fa-question"></i>
                                                                </div>
                                                                <h3 class="card-title mt-3">
                                                                    {{ __('messages.subscription_year_plan_not_found') }}
                                                                </h3>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforelse
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="pills-unlimited" role="tabpanel"
                                         aria-labelledby="pills-unlimited-tab">
                                        <div class="row justify-content-center">
                                            @forelse($subscriptionPricingUnlimitedPlans as $subscriptionsPricingPlan)
                                                @include('subscription_pricing_plans.pricing_plan_section')
                                            @empty
                                                <div class="col-lg-4 col-md-6">
                                                    <div class="card text-center empty_featured_card">
                                                        <div class="card-body d-flex align-items-center justify-content-center">
                                                            <div>
                                                                <div class="empty-featured-portfolio">
                                                                    <i class="fas fa-question"></i>
                                                                </div>
                                                                <h3 class="card-title mt-3">
                                                                    {{ __('messages.subscription_unlimited_plan_not_found') }}
                                                                </h3>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforelse
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
