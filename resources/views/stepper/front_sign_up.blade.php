@extends('layouts.auth')
@section('title')
    {{ __('messages.sign_up') }}
@endsection
@section('content')
    <div class="d-flex flex-column flex-column-fluid align-items-center justify-content-center p-4">
        <div class="col-12 text-center">
            <a href="{{ route('frontHome') }}" class="image mb-7 mb-sm-10">
                <img alt="Logo" src="{{ asset(getSettingData()['logo']) }}" class="logo">
            </a>
        </div>
        <div class="width-540">
            @include('flash::message')
            @include('layouts.errors')
        </div>
        <p class="text-center">{{__('messages.sign_up_with')}}{{ getSettingData()['application_name'] }}</p>
        <div class="bg-white rounded-15 shadow-md width-540 px-5 px-sm-7 py-10 mx-auto">
            <form method="POST" action="{{ route('sign.up') }}">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-sm-7 mb-4">
                        <label for="formInputFirstName" class="form-label">
                            {{ __('messages.user.first_name') . ':' }}<span class="required"></span>
                        </label>
                        <input id="fName" class="form-control" type="text" name="first_name" required
                            placeholder="{{ __('messages.user.first_name') }}">
                    </div>
                    <div class="col-md-6 mb-sm-7 mb-4">
                        <label for="last_name" class="form-label">
                            {{ __('messages.user.last_name') . ':' }}<span class="required"></span>
                        </label>
                        <input id="lName" class="form-control" type="text" name="last_name"
                            placeholder="{{ __('messages.user.last_name') }}" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-sm-7 mb-4">
                        <label for="email" class="form-label">
                            {{ __('messages.user.email') . ':' }}<span class="required"></span>
                        </label>
                        <input id="email" class="form-control" type="email" name="email"
                            placeholder="{{ __('messages.user.email') }}" required value="{{ session('email') ?? '' }}">
                    </div>
                </div>
                <div class="mb-5 fv-row">
                    <div class="row">
                        <div class="col-md-6 mb-sm-7 mb-4 position-relative">
                            <label for="password" class="form-label">
                                {{ __('messages.user.password') . ':' }}<span class="required"></span>
                            </label>
                            <input class="form-control" type="password" name="password" id="password"
                                placeholder="{{ __('messages.user.password') }}" required>
                            <span
                                class="position-absolute d-flex align-items-center top-0 mt-7 bottom-0 end-0 me-6 input-icon input-password-hide cursor-pointer text-gray-600 change-type">
                                <i class="fas fa-eye-slash"></i>
                            </span>
                        </div>
                        <div class="col-md-6 mb-sm-7 mb-4 position-relative">
                            <label for="password_confirmation" class="form-label">
                                {{ __('messages.user.confirm_password') . ':' }}<span class="required"></span>
                            </label>
                            <input id="password_confirmation" class="form-control" type="password"
                                name="password_confirmation" placeholder="{{ __('messages.user.confirm_password') }}"
                                required>
                            <span
                                class="position-absolute d-flex align-items-center top-0 mt-7 bottom-0 end-0 me-6 input-icon input-password-hide cursor-pointer text-gray-600 change-type">
                                <i class="fas fa-eye-slash"></i>
                            </span>
                        </div>
                        <div class="mb-sm-7 mb-4 d-flex justify-content-center">
                            @if(getSuperAdminSettingKeyValue('enable_google_recaptcha'))
                                    <div class="form-group mb-4">
                                        <div class="g-recaptcha" data-sitekey="{{getSuperAdminSettingKeyValue('google_captcha_key')}}"></div>
                                    </div>
                            @endif
                        </div>
                    </div>
                    <div class="d-grid mb-5">
                        <button type="submit" class="btn btn-primary">{{ __('messages.common.submit') }}</button>
                    </div>
                    <p>{{ __('messages.web.already_have_an_account') }}? <a href="{{ route('login') }}"
                            class="text-decoration-none">{{ __('messages.web.sign_in_here') }}</a>
                    </p>
                </div>
            </form>
        </div>
        <p class="pt-7 m-0 fs-7">{{ __('messages.creating') }} {{ getSettingData()['application_name'] }} {{ __('messages.user.account') }} <a
                href="{{ route('terms.conditions') }}" class="text-decoration-none"
                target="_blank">{{ __('messages.cms_setting.terms_conditions') }}</a>
            {{ __('and') }}
            <a href="{{ route('privacy.policy') }}" class="text-decoration-none"
                target="_blank">{{ __('messages.privacy_policy') }}</a>
        </p>
    </div>
@endsection
