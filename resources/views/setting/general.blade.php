@extends('layouts.app')
@section('title')
    {{ __('messages.setting.general') }}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="d-flex flex-column">
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="aoverview" role="tabpanel">
                    @include('setting.setting_menu')
                    {{ Form::open(['route' => 'settings.update', 'files' => true,'class'=>'form','id' => 'generalSettingForm']) }}
                    <div class="card mb-5 mb-xl-10 border-0 px-10">
                        <div class="card-header border-0 cursor-pointer ps-0 cursor-default" role="button">
                            <div class="card-title m-0">
                                <h3 class="">{{ __('messages.setting.general_details') }}</h3>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="row mb-10">
                                {{ Form::label('application_name',__('messages.setting.application_name').':',
                                         ['class'=>'col-lg-4 col-form-label required ']) }}
                                <div class="col-lg-8 fv-row">
                                    {{ Form::text('application_name',getSettingData()['application_name'], ['class' => 'form-control','placeholder'=>__('messages.setting.application_name')]) }}
                                </div>
                            </div>
                            <div class="row mb-10">
                                <div class="mb-3 col-lg-4">
                                    <label class="col-form-label fw-bold fs-6 required">{{__('messages.setting.logo')}}
                                        :</label>
                                    <span data-bs-toggle="tooltip"
                                          data-placement="top"
                                          data-bs-original-title="{{__('messages.tooltip.best_resolution')}} 90x60">
        <i class="fas fa-question-circle ml-1 mt-1 general-question-mark"></i>
</span>
                                </div>
                                <div class="mb-6 col-lg-8">
                                    <div class="d-block">
                                        <div class="image-picker">
                                            <div class="image previewImage" id="bgImage"
                                                 style="background-image: url('{{getSettingData()['logo'])?asset(getSettingData()['logo']):asset('assets/images/cal-logo.png'}}')">
                                            </div>
                                            <span class="picker-edit rounded-circle text-gray-500 fs-small"
                                                  title="{{__('messages.placeholder.change_logo')}}">
                    <label>
                        <i class="fa-solid fa-pen" id="profileImageIcon"></i>
                         <input type="file" name="logo" class="image-upload d-none" accept=".png, .jpg, .jpeg">
                    </label>
                </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3 col-lg-4">
                                    <label class="col-form-label fw-bold fs-6"><span class="required">{{__('messages.setting.favicon')}}:</span>
                                        <span data-bs-toggle="tooltip"
                                              data-placement="top"
                                              data-bs-original-title="{{__('messages.tooltip.best_resolution')}} 32X32">
        <i class="fas fa-question-circle ml-1 mt-1 general-question-mark"></i>
</span>

                                    </label>
                                </div>
                                <div class="mb-6 col-lg-8">
                                    <div class="d-block">
                                        <div class="image-picker">
                                            <div class="image previewImage" id="bgImage"
                                                 style="background-image: url('{{getSettingData()['favicon'])?asset(getSettingData()['favicon']):asset('assets/images/cal-log.png'}}')">
                                            </div>
                                            <span class="picker-edit rounded-circle text-gray-500 fs-small"
                                                  title="{{__('messages.placeholder.change_favicon')}}">
                                                    <label>
                                                        <i class="fa-solid fa-pen" id="profileImageIcon"></i>
                                                         <input type="file" name="favicon" class="image-upload d-none"
                                                                accept=".png, .jpg, .jpeg">
                                                    </label>
                                                </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-10">
                                <label class="col-lg-4 col-form-label fw-bold fs-6">
                                    {{ Form::label('currency',__('messages.setting.currency').':',['class'=>'col-lg-4 col-form-label']) }}
                                </label>
                                <div class="col-lg-8 mt-3">
                                    <select id="settingCurrencyId" data-show-content="true"
                                            class="form-select"
                                            name="currency">
                                        @foreach($currencies as $currency)
                                            <option value="{{ strtolower($currency->currency_code) }}" {{getSettingData()['currency'] == strtolower($currency->currency_code) ? 'selected' : ''}}>
                                                {{ $currency->currency_icon.' '.$currency->currency_name}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-10">
                                <label class="col-lg-4 col-form-label fw-bold fs-6">
                                    {{ Form::label('plan_expire_notification', __('messages.placeholder.plan_expire_notification').':', ['class' => 'form-label required']) }}
                                </label>
                                <div class="col-lg-8 mt-3">
                                    {{ Form::text('plan_expire_notification', getSettingData()['plan_expire_notification'], ['class' => 'form-control','maxLength'=> 2,'placeholder'=>__('messages.placeholder.plan_expire_notification')]) }}
                                </div>
                            </div>
                            <div class="row mb-10">
                                <label class="col-lg-4 col-form-label fw-bold fs-6">
                                    {{ Form::label('commands', __('messages.commands').':', ['class' => 'form-label fs-6']) }}
                                </label>
                                <div class="col-lg-8 mt-3">
                                    <a href="{{ route('remove.hold.status') }}"
                                       class="btn btn-primary" data-bs-toggle="tooltip"
                                       title="{{ __('messages.placeholder.command_change_schedule_event_status') }}">{{ __('messages.remove_hold_status') }}</a>
                                </div>
                            </div>
                            <div class="row mb-10">
                                <div class="col-lg-4 col-form-label fw-bold fs-6">
                                    {{ Form::label('auto_detect_location_enable', __('messages.user_dashboard.auto_detect_location_enable'), ['class' => 'form-label required fs-6']) }}
                                </div>
                                <div class="col-lg-8 mt-3">
                                    <div class="form-check form-switch col-6">
                                        <div class="fv-row d-flex align-items-center">
                                            {{ Form::checkbox('auto_detect_location_enable', 1, getSettingData()['auto_detect_location_enable'] ?? 0,['class' => 'form-check-input  me-5', 'id' => 'autoDetectLocation']) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-10 {{ isset(getSettingData()['auto_detect_location_enable']) && getSettingData()['auto_detect_location_enable'] == 0 ? 'd-none' : ''  }} place-api-div">
                                <div class="col-lg-4 col-form-label fw-bold fs-6">
                                    {{ Form::label('google_place_api_key', __('messages.user_dashboard.google_place_api_key'), ['class' => 'form-label required fs-6']) }}
                                </div>
                                <div class="col-lg-8 mt-3">
                                    {{ Form::text('google_place_api_key', getSettingData()['google_place_api_key'] ?? '', ['class' => 'form-control', 'placeholder' =>  __('messages.user_dashboard.google_place_api_key'), 'id' => 'googlePlaceApiKey']) }}
                                </div>
                            </div>
                            <div class="row mb-10">
                                <div class="col-lg-4 col-form-label fw-bold fs-6">
                                    {{ Form::label('default_country_code', __('messages.common.default_country_code').':', ['class' => 'form-label']) }}
                                    <span class="required"></span>
                                </div>
                                <div class="col-lg-8 mt-3">
                                    {{ Form::text('default_country_data', null, ['class' => 'form-control','placeholder'=>__('messages.common.default_country_code'), 'id'=>'defaultCountryData']) }}
                                    {{ Form::hidden('default_country_code',getSettingData()['default_country_code'] ,['id'=>'defaultCountryCode',]) }}
                                </div>
                            </div>
                            <div class="row mb-10">
                                <div class="col-lg-4 col-form-label fw-bold fs-6">
                                    {{ Form::label('enable_google_recaptcha', __('messages.enable_google_recaptcha').':', ['class' => 'form-label fs-6']) }}
                                </div>
                                <div class="col-lg-8 mt-3">
                                    <div class="form-check form-switch col-6">
                                        <div class="fv-row d-flex align-items-center">
                                            {{ Form::checkbox('enable_google_recaptcha', 1, getSettingData()['enable_google_recaptcha'] ?? 0,['class' => 'form-check-input  me-5', 'id' => 'captchaEnableAdmin']) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="captcha-div">
                                <div class="row mb-10">
                                    <div class="col-lg-4 col-form-label fw-bold fs-6">
                                        {{ Form::label('google_captcha_key', __('messages.google_captcha_key').':', ['class' => 'form-label']) }}
                                        <span class="required"></span>
                                    </div>
                                    <div class="col-lg-8 mt-3">
                                        {{ Form::text('google_captcha_key', getSettingData()['google_captcha_key'], ['class' => 'form-control','placeholder'=>__('messages.google_captcha_key'), 'id'=>'captchaKey']) }}
                                    </div>
                                </div>
                                <div class="row mb-10">
                                    <div class="col-lg-4 col-form-label fw-bold fs-6">
                                        {{ Form::label('default_country_code', __('messages.google_captcha_secret').':', ['class' => 'form-label']) }}
                                        <span class="required"></span>
                                    </div>
                                    <div class="col-lg-8 mt-3">
                                        {{ Form::text('google_captcha_secret', getSettingData()['google_captcha_secret'], ['class' => 'form-control','placeholder'=>__('messages.google_captcha_secret'), 'id'=>'captchaSecret']) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex mb-10">
                            {{ Form::submit(__('messages.common.save'),['class' => 'btn btn-primary','id'=>'settingSaveBtn']) }}
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
