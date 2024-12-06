@extends('fronts.layouts.app')
@section('front-title')
    {{ __('messages.about_us.about_us') }}
@endsection
@section('front-content')
    <div class="about-page">
        <!-- start about-content section -->
        <section class="about-content-section p-t-100 p-b-100">
            <div class="container">
                <div class="col-12">
                    <div class="hero-content max-w-1100 mx-auto ">
                        <h1 class="mb-5 pb-lg-4 text-center">
                            {{ $frontCMSSettings['about_us_title'] }}
                        </h1>
                        <p class="text-secondary fs-20 mb-0">
                            {!! $frontCMSSettings['about_us_description'] !!}
                        </p>
                    </div>
                </div>
            </div>
        </section>
        <!-- end about-content section -->

        <!-- start counts section -->
        <section class="counts-section bg-primary p-t-100 p-b-100">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-4 col-sm-6">
                        <div class="d-lg-flex text-center text-lg-start">
                            <div class="count-icon d-flex align-items-center justify-content-center">
                                <img src="{{ asset('front/images/registere-user.png')}}" alt="" loading="lazy">
                            </div>
                            <div class="ms-lg-4 ps-xxl-3">
                                <h3 class="fs-2 text-white fw-bolder">{{ $data['registeredUsersCount'] }}</h3>
                                <h4 class="text-white mb-0 fw-light">{{__('messages.web.registered_users') }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6 mt-sm-0 mt-4">
                        <div class="d-lg-flex text-center text-lg-start">
                            <div class="count-icon d-flex align-items-center justify-content-center">
                                <img src="{{asset('front/images/events-created.png')}}" alt="Events Created" loading="lazy">
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
                                <img src="{{asset('front/images/scheduled-events.png')}}" alt="Scheduled Events" loading="lazy">
                            </div>
                            <div class="ms-lg-4 ps-xxl-3">
                                <h3 class="fs-2 text-white fw-bolder">{{ $data['scheduledEventsCount'] }}</h3>
                                <h4 class="text-white mb-0 fw-light">{{__('messages.web.scheduled_events')}}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- end counts section -->
    </div>
@endsection

