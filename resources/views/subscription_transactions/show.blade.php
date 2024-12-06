@extends('layouts.app')
@section('title')
    {{ __('messages.subscription_transaction.subscription_transaction_details') }}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="d-md-flex align-items-center justify-content-between mb-5">
            <h1 class="mb-0">@yield('title')</h1>
            <div class="text-end mt-4 mt-md-0">
                <a href="{{ getLogInUser()->hasRole('user') ? route('user.subscription.transactions.index') : route('subscription.transactions.index')}}"
                   class="btn  btn-outline-primary">{{ __('messages.common.back') }}</a>
            </div>
        </div>
        <div class="d-flex flex-column">
            @include('subscription_transactions.show_fields')
        </div>
    </div>
@endsection
