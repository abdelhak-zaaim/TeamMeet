@extends('layouts.auth')
@section('title')
    {{ __('messages.event.slot_calendar') }}
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="d-flex flex-center flex-column flex-column-fluid py-4 calendar-container">
                <div class="w-100 rounded">
                    <div>
                        <div class="d-flex justify-content-between flex-md-row flex-column">
                            <div class="card shadow-sm header-card p-6">
                                <div class="card-body p-0">
                                    <div class="text-center px-2 d-sm-flex">
                                        <div
                                            class="d-flex justify-content-center align-items-center calendar-container__profile calendar-container__card shadow-sm">
                                            <div
                                                class="calendar-container__user p-5 d-flex align-items-center justify-content-center flex-column">
                                                <img src="{{ $event->user->profile_image }}" alt="logo"
                                                    class="img-fluid user-image rounded-circle object-cover">
                                                <span
                                                    class="fs-2 mt-5 fw-bold text-center d-block user-name">{{ $event->user->first_name . ' ' . $event->user->last_name }}</span>
                                            </div>
                                        </div>
                                        <div
                                            class="row justify-content-center ms-sm-5 mt-sm-0 mt-5 me-0 ms-0 calendar-container__grid">
                                            <div
                                                class="mb-5 calendar-container__card shadow-sm d-flex justify-content-center align-items-center p-5">
                                                <i class="fas fa-clock fs-1"></i>
                                                <span class="fs-2 fw-bold ms-5">{{ $event->slot_time }} min</span>
                                            </div>
                                            <div
                                                class="calendar-container__card shadow-sm d-flex justify-content-center align-items-center p-5">
                                                @if ($event->event_location == \App\Models\Event::IN_PERSON_MEETING)
                                                    @php($location = json_decode($event->location_meta))
                                                    <i class="fas fa-map-marker-alt fs-1"></i>
                                                    <span class="fs-2 fw-bold ms-5">{{ $location[1] }}</span>
                                                @elseif($event->event_location == \App\Models\Event::PHONE_CALL)
                                                    @php($phoneCallNumber = json_decode($event->location_meta))
                                                    @if (count($phoneCallNumber) > 0 && !empty($phoneCallNumber[1]))
                                                        @if (!empty($phoneCallNumber[2]) && $phoneCallNumber[1] == 2)
                                                            <i class="fa-solid fa-phone fs-1"></i>
                                                            <span class="fs-2 fw-bold ms-5">{{ $phoneCallNumber[2] }}</span>
                                                        @else
                                                            <i class="fa-solid fa-phone fs-1"></i>
                                                            <span
                                                                class="fs-2 fw-bold ms-5">{{ \App\Models\Event::LOCATION_ARRAY[$event->event_location] }}</span>
                                                        @endif
                                                    @else
                                                        <i class="fa-solid fa-phone fs-1"></i>
                                                        <span
                                                            class="fs-2 fw-bold ms-5">{{ \App\Models\Event::LOCATION_ARRAY[$event->event_location] }}</span>
                                                    @endif
                                                @else
                                                @php($location = json_decode($event->location_meta))
                                                @if(!empty($location))
                                                      @if (count($location) > 0 && $location[0] == 3)
                                                        <img src="{{ asset('assets/images/logo_google_meet.svg') }}"
                                                            alt="logo" width="25px" height="25px">
                                                        <span
                                                            class="fs-2 fw-bold ms-2">{{ \App\Models\Event::LOCATION_ARRAY[$location[0]] }}</span>
                                                    @else
                                                        {{ __('messages.common.n/a') }}
                                                    @endif
                                                @endif
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card shadow-sm header-card p-6">
                                <div class="calendar-container__header">
                                    <span class="fs-3 text-center d-block">{{ $event->name }}</span>
                                </div>
                                @if (!empty($event->description))
                                    <div class="calendar-container__description">
                                        <span class="fs-3">{!! $event->description !!}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="card shadow-sm mt-5">
                            <div class="container card-body p-sm-8 p-2">
                                <div id="calendar"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script data-turbo-eval="false">
        let currentUTCDate =
            "{{ isset(getLogInUser()->timezone) ? \App\Models\User::TIME_ZONE_ARRAY[getLogInUser()->timezone] : \App\Models\User::TIME_ZONE_ARRAY[getTimeZone()] }}"
        let eventSchedules = @json($data);
        let months = "{{ $month }}"
        let year = "{{ $slotYear }}"
        let userLanguage = "{{ $event->user->language }}"
        let slotCalendarUrl = "{{ Request::root() . '/s/' . $event->user->domain_url . '/' . $event->event_link }}"
    </script>
@endpush
