@extends('layouts.auth')
@section('title')
    {{__('messages.login')}}
@endsection
@section('content')
    <div class="d-flex flex-column flex-column-fluid align-items-center justify-content-center p-4">
        <div class="col-12 text-center">
            <a href="{{ route('frontHome') }}" class="image mb-7 mb-sm-10">
                <img alt="Logo" src="{{ asset(getSettingData()['logo']) }}" class="logo" loading="lazy">
            </a>
        </div>
        <div class="width-540">
            @include('flash::message')
            @include('layouts.errors')
        </div>
        <div class="bg-white rounded-15 shadow-md width-540 px-5 px-sm-7 py-10 mx-auto">
            <h1 class="text-center mb-7">{{__('messages.sign_in_to')}} {{ getSettingData()['application_name'] }}</h1>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-sm-7 mb-4">
                    <label for="email" class="form-label">
                        {{ __('messages.user.email').':' }}<span class="required"></span>
                    </label>
                    <input id="email" class="form-control"
                           type="email" name="email" required autocomplete="off"
                           value="{{ (Cookie::get('email') !== null) ? Cookie::get('email') : old('email') }}"
                           placeholder={{ __('messages.user.email')  }} autofocus/>
                </div>

                <div class="mb-sm-7 mb-4 position-relative">
                    <div class="d-flex justify-content-between">
                        <label for="password" class="form-label">{{ __('messages.user.password') .':' }}<span
                                    class="required"></span></label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="link-info fs-6 text-decoration-none">
                                {{ __('messages.forgot_your_password') }}
                            </a>
                        @endif
                    </div>
                    <input id="password" class="form-control"
                           type="password"
                           name="password"
                           value="{{ (Cookie::get('password') !== null) ? Cookie::get('password') : null }}"
                           required placeholder="{{__('messages.user.password')}}" autocomplete="current-password"/>
                    <span class="position-absolute d-flex align-items-center top-0 bottom-0 end-0 mt-7 me-4 input-icon input-password-hide cursor-pointer text-gray-600 change-type">
                                <i class="fas fa-eye-slash"></i>
                            </span>
                </div>

                <div class="mb-sm-7 mb-4 form-check">
                    <input type="checkbox" name="remember" class="form-check-input"
                           id="remember_me" {{ (Cookie::get('remember') !== null) ? 'checked' : '' }}>
                    <label class="form-check-label" for="formCheck">{{ __('messages.remember_me') }}</label>
                </div>
                <div class="mb-sm-7 mb-4 d-flex justify-content-center">
                    @if(getSuperAdminSettingKeyValue('enable_google_recaptcha'))
                            <div class="form-group mb-4">
                                <div class="g-recaptcha" data-sitekey="{{getSuperAdminSettingKeyValue('google_captcha_key')}}"></div>
                            </div>
                    @endif
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">{{ __('messages.login') }}</button>
                </div>
                <div class="d-flex align-items-center mb-10 mt-4">
                    <span class="text-gray-700 me-2">{{__('messages.web.new_here').'?'}}</span>
                    <a href="{{ route('sign.up') }}" class="link-info fs-6 text-decoration-none">
                        {{__('messages.web.create_an_account')}}
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
