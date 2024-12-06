@extends('layouts.auth')
@section('title')
    {{ __('messages.schedule_event.cancel_schedule_event') }}
@endsection
@section('page_css')
    <link href="{{ mix('assets/css/front-custom.css') }}" rel="stylesheet" type="text/css"/>
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
                @include('flash::message')
                @php
                    $styleCss = 'style';
                @endphp
                <div class="w-lg-900px bg-white rounded shadow-sm">
                    <div {{ $styleCss }}="height:auto;">
                    <div class="border-bottom">
                        <div>
                            <div class="card">
                                <div class="justify-content-center">
                                    <div class="d-flex h-750px main-details">
                                        <div class="border-end py-7 px-7 col-12 col">
                                            <div class="mb-5 mt-10 d-flex justify-content-center flex-column">
                                                <h2 class="mb-0 text-center">{{ __('messages.common.cancel') }}</h2>
                                                <span class="fs-4 mt-3 text-center">{{ __('messages.event.you_are_scheduled') }} {{ __('messages.event.with') }} {{ $eventSchedule->user->first_name.' '.$eventSchedule->user->last_name }}.</span>
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
        </div>
    </div>
@endsection

