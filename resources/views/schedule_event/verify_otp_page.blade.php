@extends('layouts.auth')
@section('title')
    {{ __('messages.schedule_event.verify_otp') }}
@endsection
@section('page_css')
    <link href="{{ mix('assets/css/front-custom.css') }}" rel="stylesheet" type="text/css"/>
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="mt-5 justify-content-center w-lg-900px mx-auto px-0">
            </div>
            @php
                $styleCss = 'style';
            @endphp
            <div class="d-flex flex-center flex-column flex-column-fluid p-4 p-sm-10 pb-lg-20">
                @include('flash::message')
                @include('layouts.errors')
                <div class="w-lg-900px bg-white rounded shadow-sm">
                    <div {{ $styleCss }}="height:auto;">
                    <div class="border-bottom">
                        <div class="card">
                            {{ Form::open(['route' => 'check.given.otp','id' => 'checkOTPForm', 'method' => 'post']) }}
                            <div class="justify-content-center">
                                <div class="d-flex h-750px main-details">
                                    <div class="border-end py-7 px-7 col-12 col">
                                        <div class="mb-3 mt-10 d-flex justify-content-center flex-column">
                                            <h2 class="mb-0 text-center">{{ __('messages.schedule_event.verify_your_otp_for_cancel_schedule_event') }}</h2>
                                        </div>
                                        @php
                                            $styleCss = 'style';
                                        @endphp
                                        <div class="mt-20 py-5 mb-4"
                                        {{ $styleCss }}="max-width: 500px;width: 100%;margin: 0 auto;display: block;">
                                        <div class="d-sm-flex d-block justify-content-center align-items-center">
                                            {{ Form::label('otp',__('messages.schedule_event.otp').':' ,['class' => 'form-label required fs-6 fw-bolder text-gray-700 mb-3']) }}
                                            {{ Form::text('otp', null,['class' => 'form-control ms-0 ms-sm-3','placeholder' => __('messages.placeholder.enter_otp'),'onkeyup' => 'if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,"")','minLength' => 6,'maxLength' => 6]) }}
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        {{ Form::submit(__('messages.common.save'),['class' => 'btn btn-primary','id' => 'checkOTP']) }}
                                    </div>
                                </div>
                            </div>
                                </div>
                                {{ Form::close() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('page_js')
    <script src="{{ mix('assets/js/schedule_events/check-otp.js') }}"></script>
@endsection
