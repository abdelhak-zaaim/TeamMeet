@extends('layouts.auth')
@section('title')
    {{ __('messages.schedule_event.confirm_schedule_event') }}
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
                @include('flash::message')
                <div class="w-lg-900px bg-white rounded shadow-sm">
                    @php
                        $styleCss = 'style';
                    @endphp
                    <div {{ $styleCss }}="height:auto;">
                        <div class="border-bottom">
                            <div>
                                <div class="card">
                                    <div class="justify-content-center">
                                        <div class="d-flex h-750px main-details">
                                            <div class="border-end py-7 px-7 col-12 col">
                                                <div class="mb-5 mt-10 d-flex justify-content-center flex-column">
                                                    <h2 class="mb-0 text-center">{{ __('messages.common.confirmed') }}</h2>
                                                    <span
                                                        class="fs-4 mt-3 text-center">{{ __('messages.event.you_are_scheduled_confirmed') }}
                                                        {{ $eventSchedule->event->name }} {{ __('messages.event.with') }}
                                                        {{ $eventSchedule->user->first_name . ' ' . $eventSchedule->user->last_name }}.</span>
                                                </div>
                                                @if (!empty($cancelScheduleEvent))
                                                    <h2 class="text-center">
                                                        {{ __('messages.event.are_you_sure_want_to_cancel_this_schedule_event') }}
                                                        ?</h2>
                                                    {{ Form::open(['route' => ['verify.otp', $eventSchedule->event->user->domain_url, $eventSchedule->event->event_link, $eventSchedule->uuid], 'method' => 'post']) }}
                                                    <div class="mb-1 mt-10 d-flex justify-content-center">
                                                        {{ Form::hidden('schedule_event_id', $eventSchedule->id) }}
                                                        <button type="submit"
                                                            class="btn btn-primary me-3">{{ __('messages.common.yes') }}</button>
                                                        <a href="{{ getSlotConfirmPageUrl($eventSchedule) }}"
                                                            class="btn btn-danger">{{ __('messages.common.no') }}</a>
                                                    </div>
                                                    {{ Form::close() }}
                                                @endif
                                                <div class="mt-10 border border-start-0 border-end-0 border-bottom-0 py-5"
                                                    {{ $styleCss }}="max-width: 500px;width: 100%;margin: 0 auto;display: block;
                                            ">
                                                    <div class="d-flex align-items-center">
                                                        <i class="fa fa-circle fs-2"
                                                            {{ $styleCss }}="color: #8247f5;"></i>
                                                        <span class="ms-3 fs-4 ">
                                                            {{ $eventSchedule->event->name }}
                                                        </span>
                                                    </div>
                                                    <div class="d-flex align-items-center mt-4">
                                                        <i class="fa fa-calendar fs-2 text-warning"></i>
                                                        {{--                                                <span class="ms-3 fs-4 "> --}}
                                                        {{--                                                           {{ $eventSchedule->slot_time  }}, {{ \Carbon\Carbon::parse($eventSchedule->schedule_date)->translatedFormat('l') }}, {{ \Carbon\Carbon::parse($eventSchedule->schedule_date)->translatedFormat('F j, Y') }} --}}
                                                        {{--                                                        </span> --}}
                                                        {{-- <span class="ms-3 fs-4 ">
                                                           {{ getTimezoneWiseUserSlotTime($eventSchedule->user, $eventSchedule->slot_time)  }}, {{ \Carbon\Carbon::parse($eventSchedule->schedule_date)->translatedFormat('l') }}, {{ \Carbon\Carbon::parse($eventSchedule->schedule_date)->translatedFormat('F j, Y') }}
                                                        </span> --}}
                                                        <span class="ms-3 fs-4 ">
                                                            {{ $eventSchedule->slot_time }},
                                                            {{ \Carbon\Carbon::parse($eventSchedule->schedule_date)->translatedFormat('l') }},
                                                            {{ \Carbon\Carbon::parse($eventSchedule->schedule_date)->translatedFormat('F j, Y') }}
                                                        </span>
                                                    </div>
                                                    <div class="d-flex align-items-center mt-4">
                                                        <i class="fa fa-globe-asia fs-2 text-danger"></i>
                                                        <span class="ms-3 fs-4 ">
                                                            {{ \App\Models\User::TIME_ZONE_ARRAY[$eventSchedule->event->user->timezone] }}
                                                        </span>
                                                    </div>
                                                    <div class="d-flex align-items-center mt-4">
                                                        @if ($eventSchedule->event->event_location == \App\Models\Event::IN_PERSON_MEETING)
                                                            <i class="fa fa-map-marker-alt fs-2 text-success"></i>
                                                            @php($location = json_decode($eventSchedule->event->location_meta))
                                                            <span class="ms-3 fs-4 ">{{ $location[1] }}</span>
                                                        @elseif($eventSchedule->event->event_location == \App\Models\Event::PHONE_CALL)
                                                            @php($phoneCallNumber = json_decode($eventSchedule->event->location_meta))
                                                            @if (count($phoneCallNumber) > 0 && !empty($phoneCallNumber[1]))
                                                                @if (!empty($phoneCallNumber[2]) && $phoneCallNumber[1] == 2)
                                                                    <i class="fa-solid fa-phone fs-2 text-black"></i>
                                                                    <span
                                                                        class="ms-3 fs-4 ">{{ $phoneCallNumber[2] }}</span>
                                                                @else
                                                                    <i class="fa-solid fa-phone text-black"></i>
                                                                    <span
                                                                        class="ms-3 fs-4">{{ \App\Models\Event::LOCATION_ARRAY[$eventSchedule->event->event_location] }}</span>
                                                                @endif
                                                            @else
                                                                <i class="fa-solid fa-phone text-black"></i>
                                                                <span
                                                                    class="ms-3 fs-4 ">{{ \App\Models\Event::LOCATION_ARRAY[$eventSchedule->event->event_location] }}</span>
                                                            @endif
                                                        @else
                                                            @if (!empty($eventSchedule->userGoogleEventSchedule->google_meet_link))
                                                                @php($location = json_decode($eventSchedule->event->location_meta))
                                                                <img src="{{ asset('assets/images/logo_google_meet.svg') }}"
                                                                    alt="logo" width="25px" height="25px">
                                                                <a href="{{ $eventSchedule->userGoogleEventSchedule->google_meet_link }}"
                                                                    class="ms-3 fs-4"
                                                                    target="_blank">{{ \App\Models\Event::LOCATION_ARRAY[$eventSchedule->event->event_location] }}</a><span
                                                                    class="ms-2 cursor-pointer copy-google-meet-link"
                                                                    data-link="{{ $eventSchedule->userGoogleEventSchedule->google_meet_link }}"><i
                                                                        class="fa fa-copy"
                                                                        style="color: #009ef7"></i></span>
                                                            @endif
                                                        @endif
                                                    </div>
                                                    <div
                                                        class="d-flex align-items-center justify-content-around mt-5 flex-wrap flex-md-wrap">
                                                        <a href="{{ route('add.calendar', $eventSchedule->id) }}"
                                                            class="btn btn-primary mb-sm-0 mb-4" data-turbo="false"
                                                            id="addCalendar"><i class="fas fa-calendar-alt"
                                                                aria-hidden="true"></i>
                                                            {{ __('messages.event.add_google_calendar') }}</a>
                                                        <a href="{{ $downloadIcsFileLink }}" class="btn btn-primary"><i
                                                                class="fa fa-download" aria-hidden="true"></i>
                                                            {{ __('messages.event.download_ics_file') }}</a>
                                                    </div>
                                                    @if (Auth::check())
                                                        <div class="d-flex justify-content-center mt-4">
                                                            <div>
                                                                <a href="{{ getLogInUser()->hasRole('admin') ? route('admin.dashboard') : route('dashboard') }}"
                                                                    class="btn btn-primary" data-turbo="false">
                                                                    {{ __('messages.go_to_dashboard') }}
                                                                </a>
                                                            </div>
                                                        </div>
                                                    @endif
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
