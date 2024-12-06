@extends('fronts.layouts.app')
@section('front-title')
    {{ __('messages.home') }}
@endsection
@section('front-css')
    <link href="{{ asset('front/css/home.css') }}" rel="stylesheet" type="text/css">
@endsection
@section('front-content')
    <div class="home-page">
        <!-- start hero section -->
        <section class="hero-section p-t-100 p-b-100">
            <div class="container">
                <div class="row align-items-center flex-column-reverse flex-lg-row">
                    <div class="col-lg-6 text-lg-start text-center">
                        <div class="hero-content mt-5 mt-lg-0">
                            <h1 class="mb-3 pb-1">
                          {{ $frontCMSSettings['title'] }}
                            </h1>
                            <p class="fs-4 mb-lg-5 mb-4 pb-2">
                              {{$frontCMSSettings['description']}}.</p>
                            @if(!getLogInUser())
                            <form action="{{ route('email.sign.up') }}">
                                <div class="input-group mb-md-3">
                                    <input type="email" name="email" class="form-control"
                                           placeholder="{{__('messages.placeholder.enter_your_email')}}" aria-label="{{__('messages.placeholder.enter_your_email')}}"
                                           aria-describedby="basic-addon2">
                                    <button type="submit" class="input-group-text px-5" id="basic-addon2" data-turbo="false">
                                        {{__('messages.web.get_started')}}
                                    </button>
                                </div>
                            </form>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-6 text-lg-end text-center">
                        <img src="{{ asset($frontCMSSettings['front_image']) }}" alt="img" class="img-fluid" loading="lazy"/>
                    </div>
                </div>
            </div>
        </section>
        <!-- end hero section -->

        <!-- start company logo section -->
        <section class="company-logo-section bg-light">
            <div class="container">
                <div class="row">
                    @if(count($data['brands']) == 0)
                    <div class="company-logo-block text-center">
                        <img src="{{asset('front/images/google-logo.png')}}" alt="Google" class="img-fluid" loading="lazy">
                    </div>
                    <div class="company-logo-block text-center">
                        <img src="{{asset('front/images/uber-logo.png')}}" alt="Uber" class="img-fluid" loading="lazy">
                    </div>
                    <div class="company-logo-block text-center">
                        <img src="{{asset('front/images/airbnb-logo.png')}}" alt="Airbnb" class="img-fluid" loading="lazy">
                    </div>
                    <div class="company-logo-block text-center">
                        <img src="{{asset('front/images/stripe-logo.png')}}" alt="Stripe" class="img-fluid" loading="lazy">
                    </div>
                    <div class="company-logo-block text-center">
                        <img src="{{asset('front/images/slack-logo 2.png')}}" alt="Slack" class="img-fluid" loading="lazy">
                    </div>
                    <div class="company-logo-block text-center">
                        <img src="{{asset('front/images/pipedrive-logo.png')}}" alt="Pipedrive" class="img-fluid" loading="lazy">
                    </div>
                    @endif
                    @foreach($data['brands'] as $brand)
                        <div class="company-logo-block text-center">
                            <img src="{{ $brand->brand_logo }}" alt="" class="img-fluid" loading="lazy">
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
        <!-- end company logo section -->

        <!-- start services section -->
        <section class="services-section p-t-100 p-b-100">
            <div class="container">
                <h2 class="m-b-60 max-w-620 text-center mx-auto">{{$data['services']['main_title'] }}</h2>
                <div class="row justify-content-center">
                    <div class="col-xl-4 col-md-6 service-block d-flex align-items-stretch">
                        <div class="card service-inner text-center mx-lg-2 flex-fill">
                            <div class="card-body d-flex flex-column">
                                <div class="service-icon pb-3 mb-4">
                                    <img src="{{ $data['services']['service_image_1'] }}" alt="smart-popups" class="img-fluid" loading="lazy">
                                </div>
                                <h4 class="mb-3">{{ $data['services']['service_title_1'] }}</h4>
                                <p class="fs-6 text-secondary fw-light mb-0">
                                    {{ $data['services']['service_description_1'] }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6 service-block d-flex align-items-stretch mt-md-0 mt-4">
                        <div class="card service-inner text-center mx-lg-2 flex-fill">
                            <div class="card-body d-flex flex-column">
                                <div class="service-icon pb-3 mb-4">
                                    <img src="{{ $data['services']['service_image_2'] }}" alt="smart-popups" class="img-fluid" loading="lazy">
                                </div>
                                <h4 class="mb-3">{{ $data['services']['service_title_2'] }}</h4>
                                <p class="fs-6 text-secondary fw-light mb-0">
                                    {{ $data['services']['service_description_2'] }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6 service-block d-flex align-items-stretch mt-xl-0 mt-4 pt-xl-0 pt-lg-3">
                        <div class="card service-inner text-center mx-lg-2 flex-fill">
                            <div class="card-body d-flex flex-column">
                                <div class="service-icon pb-3 mb-4">
                                    <img src="{{ $data['services']['service_image_3'] }}" alt="smart-popups" class="img-fluid" loading="lazy">
                                </div>
                                <h4 class="mb-3">{{ $data['services']['service_title_3'] }}</h4>
                                <p class="fs-6 text-secondary fw-light mb-0">
                                    {{ $data['services']['service_description_3'] }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- end services section -->

        <!-- start reason-choose section -->
        <section class="reason-choose-section p-b-100">
            <div class="container">
                <div class="row bg-light g-0 rounded-50">
                    <div class="col-xxl-6">
                        <div class="reason-content">
                            <h2 class="m-b-60 text-xxl-start text-center">{{ $mainReasons['main_title']}}</h2>
                            <div class="accordion" id="accordionExample">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingOne">
                                        <button class="accordion-button  px-0 pt-0" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true"
                                                aria-controls="collapseOne">
                                            {{ $mainReasons['title_1'] }}
                                        </button>
                                    </h2>
                                    <div id="collapseOne" class="accordion-collapse collapse show"
                                         aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                        <div class="accordion-body px-0">
                                            <p class="fs-6 text-secondary fw-light mb-0">
                                                {{ $mainReasons['description_1']}}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingTwo">
                                        <button class="accordion-button  px-0 pt-0 collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapseTwo"
                                                aria-expanded="false" aria-controls="collapseTwo">
                                            {{ $mainReasons['title_2']}}
                                        </button>
                                    </h2>
                                    <div id="collapseTwo" class="accordion-collapse collapse"
                                         aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                        <div class="accordion-body px-0">
                                            <p class="fs-6 text-secondary fw-light mb-0">
                                                {{ $mainReasons['description_2']}}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingThree">
                                        <button class="accordion-button  px-0 pt-0 collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapseThree"
                                                aria-expanded="false" aria-controls="collapseThree">
                                            {{ $mainReasons['title_3']}}
                                        </button>
                                    </h2>
                                    <div id="collapseThree" class="accordion-collapse collapse"
                                         aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                        <div class="accordion-body px-0">
                                            <p class="fs-6 text-secondary fw-light mb-0">
                                                {{ $mainReasons['description_3']}}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-6 choose-image d-none d-xxl-block">
                        <img src="{{ asset($mainReasons['image']) }}" alt="img" class="img-fluid h-100" loading="lazy">
                    </div>
                </div>
            </div>
        </section>
        <!-- end reason-choose section -->

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
                                <img src="{{asset('front/images/scheduled-events.png')}}" alt="Scheduled Events" loading="lazy" >
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

        <!-- start testimonial section -->
        <section class="testimonial-section p-t-100 p-b-100">
            <div class="container">
                <div class="row position-relative">
                    <div class="col-xl-4 pe-4">
                        <h2 class="text-start d-none d-xl-block">{{ __('messages.web.whats') }} </br> {{ __('messages.web.our_client_say') }} </br> {{ __('messages.web.about_us') }}</h2>
                        <h2 class="text-center d-block d-xl-none">{{ __('messages.web.whats') }} {{ __('messages.web.our_client_say') }} {{ __('messages.web.about_us') }}</h2>
                        <img src="{{asset('front/images/quotation.png')}}" alt="quotation"
                             class="img-fluid ms-auto d-block d-none d-xl-block" loading="lazy">
                    </div>
                    <div class="col-xl-8">
                        <div class="testimonial-section__testimonial-block mx-auto">
                            <div class="testimonial-carousel">
                                @foreach($data['frontTestimonials'] as $frontTestimonial)
                                    <div class="testimonial-section__testimonial-card border rounded-20 position-relative me-2">
                                        <p class="text-secondary fs-4 mb-5">
                                            {{ $frontTestimonial->short_description }}
                                        </p>
                                        <div class="d-flex profile-box align-items-center">
                                            <img src="{{ $frontTestimonial->front_profile }}" alt="profile"
                                                 class="profile-img rounded-circle img-fluid" loading="lazy">
                                            <span class="ms-3">
                                            <h3 class="profile-name mb-md-2 mb-1">{{ $frontTestimonial->name }}</h3>
                                            <h4 class="profike-designation fw-light fs-6 text-secondary mb-0">{{ $frontTestimonial->designation }}</h4>
                                        </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- end testimonial section -->

        @endsection
        @section('front_scripts')
            <script>
                $('.testimonial-carousel').slick({
                    dots: false,
                    centerPadding: '0',
                    slidesToShow: 1,
                    slidesToScroll: 1,
                })
            </script>
@endsection
