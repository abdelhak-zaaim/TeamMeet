<!-- start subscribe section -->
<section class="subscribe-section p-b-100 p-t-100">
    <div class="container">
        <div class="col-12 bg-light rounded-50 p-60">
            <div class="row align-items-center">
                <div class="col-xxl-7 col-lg-5">
                    <h2>{{ __('messages.subscribe_now') }}.</h2>
                    <h4 class="text-primary mb-0">{{__('messages.start_free_trial')}}</h4>
                </div>
                <div class="col-xxl-5 col-lg-7 mt-4 mt-lg-0">
                    {{ Form::open(['route' => 'subscribe.store','id' => 'subscribeForm']) }}
                    <div class="subscribe-inputgrp position-relative">
                        <input name="email" type="email" class="form-control subscribe-input"
                               placeholder="{{__('messages.web.email_address')}}" required>
                        <div class="subscribe-btn d-flex align-items-center">
                            <button type="submit" class="btn btn-primary"
                                    id="btnSaveSubscribe">{{__('messages.subscribe')}}</button>
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
</section>
<!-- end subscribe section -->
<footer class="bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-6 mb-md-0 mb-3">
                <a href="{{ route('frontHome') }}">
                    <img src="{{ asset(getSettingData()['logo']) }}" alt="" class="img-fluid footer-logo" loading="lazy">
                </a>
                <ul class="d-flex ps-0 social-list">
                    @if(!empty($frontCMSSettings['facebook_url']))
                        <li class="d-flex align-items-center justify-content-center">
                            <a href="{{ $frontCMSSettings['twitter_url'] }}"
                               class="text-decoration-none d-block text-white" target="_blank">
                                <i class="fa-brands fa-twitter fs-5"></i>
                            </a>
                        </li>
                    @endif
                    @if(!empty($frontCMSSettings['facebook_url']))
                        <li class="d-flex align-items-center justify-content-center">
                            <a href="{{ $frontCMSSettings['facebook_url'] }}"
                               class="text-decoration-none d-block text-white" target="_blank">
                                <i class="fa-brands fa-facebook-f fs-5"></i>
                            </a>
                        </li>
                    @endif
                    @if(!empty($frontCMSSettings['instagram_url']))
                        <li class="d-flex align-items-center justify-content-center">
                            <a href="{{ $frontCMSSettings['instagram_url'] }}"
                               class="text-decoration-none d-block text-white" target="_blank">
                                <i class="fa-brands fa-instagram fs-5"></i>
                            </a>
                        </li>
                    @endif
                </ul>

            </div>
            <div class="col-lg-4 col-md-6 mb-md-0 mb-3">
                <h3 class="mb-4 pb-1">{{__('messages.services')}}</h3>
                    <ul class="ps-0">
                        <li>
                            <a href="{{ route('pricing') }}"
                            class="text-decoration-none  mb-3 d-block fw-light {{ Request::is('pricing*') ? 'active' : 'text-secondary' }}">{{__('messages.pricing')}}</a>
                        </li>
                        <li>
                            <a href="{{ route('about-us') }}"  class="text-decoration-none  mb-3 d-block fw-light {{ Request::is('about-us*') ? 'active' : 'text-secondary' }}">{{__('messages.about_us.about_us')}}</a>
                        </li>
                        <li>
                            <a href="{{ route('contact-us') }}"  class="text-decoration-none  mb-3 d-block fw-light {{ Request::is('contact-us*') ? 'active' : 'text-secondary' }}">{{__('messages.contact_us')}}
                            </a></li>
                        <li>
                            <a href="{{ route('faq')}}" class="text-decoration-none  mb-3 d-block fw-light {{ Request::is('faq*') ? 'active' : 'text-secondary'}}">{{__('messages.faqs')}}</a>
                        </li>
                        <li>
                            <a href="{{ route('terms.conditions') }}"
                               class="text-decoration-none  mb-3 d-block fw-light {{ request()->routeIs('terms.conditions') ? 'active' : 'text-secondary' }}">{{__('messages.terms_conditions')}}</a>
                        </li>
                        <li>
                            <a href="{{ route('privacy.policy') }}"
                               class="text-decoration-none  mb-3 d-block fw-light {{ request()->routeIs('privacy.policy') ? 'active' : 'text-secondary' }}">{{(__('messages.privacy_policy'))}}</a>
                        </li>
                    </ul>
            </div>
            <div class="col-lg-4 col-12">
                <h3 class="mb-4 pb-1">{{__('messages.common.address')}}</h3>
                    <div class="footer-info">
                        <div class="d-flex align-items-center footer-info__block mb-3 pb-1">
                            <i class="fa-solid fa-envelope text-primary fs-5 me-3"></i>
                            <a href="mailto:{{ $frontCMSSettings['email'] }}" class="text-decoration-none text-secondary fs-6">
                                {{ $frontCMSSettings['email'] }}
                            </a>
                        </div>
                        <div class="d-flex align-items-center footer-info__block mb-3 pb-1">
                            <i class="fa-solid fa-phone text-primary fs-5 me-3"></i>
                            <a href="tel:+{{ $frontCMSSettings['region_code'] }} {{ $frontCMSSettings['phone'] }}" class="text-decoration-none text-secondary fs-6">
                                +{{ $frontCMSSettings['region_code'] }} {{ $frontCMSSettings['phone'] }}
                            </a>
                        </div>
                    </div>

            </div>
            <div class="col-12 text-center mt-lg-5 mt-4 copy-right">
                <p class="fw-light py-4 mb-0">{{ __('messages.copyright') }} ©{{ \Carbon\Carbon::now()->year }} {{ getSettingData()['application_name'] }}</p>
            </div>
        </div>
    </div>
</footer>
