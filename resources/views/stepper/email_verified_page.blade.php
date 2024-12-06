@extends('layouts.auth')
@section('title')
    {{ __('messages.web.email_verify') }}
@endsection
@section('page_css')
    <link rel="stylesheet" type="text/css" href="{{ mix('assets/css/front/custom.css') }}">
@endsection
@section('content')
    <div class="container mt-10">
        @include('flash::message')
    </div>
    <div class="d-flex flex-center flex-column flex-column-fluid top-30 position-relative">
        <div class="text-center align-items-center justify-content-center mb-2">
            <img src="{{ asset(getSettingData()['logo']) }}" class="mb-10 logo" alt="logo"/>
            <p class="fs-4"><b>{{ $user->first_name }},</b><br>
                {{ __('messages.web.thank_you_for_confirming_your_email_address') }}, <b>{{ $user->email }}</b><br>
                {{ __('messages.web.lets_log_in_and_finish_getting_you_started') }}!<br>
            </p>
            <a href="{{ route('login') }}" class="btn btn-primary">{{ __('messages.login') }}</a>
        </div>
    </div>
@endsection
