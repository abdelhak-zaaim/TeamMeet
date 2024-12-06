@extends('fronts.layouts.app')
@section('front-title')
    {{ __('messages.contact_us') }}
@endsection
@section('front-css')
    <link href="{{ asset('front/css/contact.css') }}" rel="stylesheet" type="text/css">
@endsection
@section('front-content')
    <div class="contact-page">
        <!-- start services section -->
        <section class="contact-info-section p-t-100 p-b-100">
            <div class="container">
                <h2 class="m-b-60 max-w-620 text-center mx-auto">{{ $services['main_title'] }}</h2>
                <div class="row justify-content-center p-t-60">
                    <div class="col-xl-4 col-md-6 contact-info-block">
                        <div class="card contact-info-inner text-center mx-lg-2 h-100">
                            <div class="card-body">
                                <div class="contact-info-icon pb-3 mb-4">
                                    <img src="{{ asset('front/images/location.png') }}" alt="Location"
                                         class="img-fluid" loading="lazy">
                                </div>
                                <h4 class="mb-3">{{__('messages.web.location')}}</h4>
                                <p class="fs-6 text-secondary fw-light mb-0">
                                    {{ __( $frontCMSSettings['address']) }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6 contact-info-block mt-md-0 mt-4">
                        <div class="card contact-info-inner text-center mx-lg-2 h-100">
                            <div class="card-body">
                                <div class="contact-info-icon pb-3 mb-4">
                                    <img src="{{asset('front/images/contact.png')}}" alt="Contact" class="img-fluid" loading="lazy">
                                </div>
                                <h4 class="mb-3">{{ __('messages.cms_setting.contact') }}</h4>
                                <div class="mb-2">
                                    <a href="mailto:{{ $frontCMSSettings['email'] }}"
                                       class="text-decoration-none text-secondary fs-6">
                                        {{ $frontCMSSettings['email'] }}
                                    </a>
                                </div>
                                <div>
                                    <a href="tel:+{{ $frontCMSSettings['region_code'] }} {{ $frontCMSSettings['phone'] }}"
                                       class="text-decoration-none text-secondary fs-6">
                                        +{{ $frontCMSSettings['region_code'] }} {{ $frontCMSSettings['phone'] }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6 contact-info-block mt-xl-0 mt-4 pt-xl-0 pt-lg-3">
                        <div class="card contact-info-inner text-center mx-lg-2 h-100">
                            <div class="card-body">
                                <div class="contact-info-icon pb-3 mb-4">
                                    <img src="{{ asset('front/images/social.png') }}" alt="Social" class="img-fluid" loading="lazy">
                                </div>
                                <h4 class="mb-3">{{__('messages.web.social_media')}}</h4>
                                <div class="">
                                    <p class="fs-6 text-secondary fw-light mb-0">
                                        {{__('messages.web.find_on_social_media')}}
                                    </p>
                                    <ul class="d-flex ps-0 social-list justify-content-center">
                                        @if(!empty($frontCMSSettings['twitter_url']))
                                            <li class="d-flex align-items-center justify-content-center">
                                                <a href="{{$frontCMSSettings['twitter_url']}}" target="_blank"
                                                   class="text-decoration-none d-block text-white">
                                                    <i class="fa-brands fa-twitter fs-5"></i>
                                                </a>
                                            </li>
                                        @endif
                                        @if(!empty($frontCMSSettings['facebook_url']))
                                            <li class="d-flex align-items-center justify-content-center">
                                                <a href="{{ $frontCMSSettings['facebook_url'] }}" target="_blank"
                                                   class="text-decoration-none d-block text-white">
                                                    <i class="fa-brands fa-facebook-f fs-5"></i>
                                                </a>
                                            </li>
                                        @endif
                                        @if(!empty($frontCMSSettings['instagram_url']))
                                            <li class="d-flex align-items-center justify-content-center">
                                                <a href="{{$frontCMSSettings['instagram_url']}}" target="_blank"
                                                   class="text-decoration-none d-block text-white">
                                                    <i class="fa-brands fa-instagram fs-5"></i>
                                                </a>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- end services section -->

        <!-- start contact-form section -->
        <section class="bg-primary contact-form-section">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <form class="contact-form" method="post" id="contactForm">
                            @csrf
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="contact-form__input-block">
                                        <input name="first_name" id="name" type="text" class="form-control"
                                               placeholder="{{ __('messages.user.first_name')}}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="contact-form__input-block">
                                        <input name="last_name" id="name" type="text" class="form-control"
                                               placeholder="{{ __('messages.user.last_name')}}">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="contact-form__input-block">
                                        <input name="email" id="email" type="email" class="form-control"
                                               placeholder="{{__('messages.web.email_address')}}">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="contact-form__input-block">
                                        <textarea name="message" id="message" rows="4"
                                                  class="form-control form-textarea"
                                                  placeholder="{{__('messages.web.your_message')}}"></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-12 text-center mt-4 mb-5">
                                    <button type="submit" class="btn btn-outline-light"
                                            id="contactSubmitBtn">{{__('messages.web.send_message')}}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-lg-6 text-lg-end text-center d-none d-lg-block">
                        <img src="{{asset('front/images/contact-hero.png')}}" alt="" class="img-fluid" loading="lazy"/>
                    </div>
                </div>
            </div>
        </section>
        <!-- end contact-form section -->
        @endsection
