@extends('layouts.app')
@section('title')
    {{ __('messages.subscription_plan.view_subscription_plan')}}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-end mb-5">
            <h1 class="mb-0">@yield('title')</h1>
            <div class="text-end mt-4 mt-md-0">
                <a href="{{route('subscription-plans.edit', $subscriptionPlans->id)}}"
                   class="btn btn-primary subscriptionPlan-edit ms-2 mt-3 ">{{ __('messages.common.edit') }}</a>
                <a href="{{ route('subscription-plans.index') }}"
                   class="btn btn-outline-primary ms-2 mt-3">{{ __('messages.common.back') }}</a>
            </div>
        </div>
        <div class="d-flex flex-column">
            @include('subscription_plans.show_fields')
        </div>
    </div>
@endsection
