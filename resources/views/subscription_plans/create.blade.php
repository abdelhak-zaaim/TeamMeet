@extends('layouts.app')
@section('title')
    {{__('messages.subscription_plan.add_subscription_plan')}}
@endsection
@section('header_toolbar')
    <div class="container-fluid">
        <div class="d-md-flex align-items-center justify-content-between mb-5">
            <h1 class="mb-0">@yield('title')</h1>
            <a href="{{ route('subscription-plans.index')  }}"
               class="btn btn-outline-primary">{{ __('messages.common.back') }}</a>
        </div>
    </div>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="d-flex flex-column">
            <div class="row">
                <div class="col-12">
                    @include('layouts.errors')
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    {{ Form::open(['route' => 'subscription-plans.store', 'id' => 'createSubscriptionPlanForm']) }}
                        @include('subscription_plans.fields')
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@endsection
