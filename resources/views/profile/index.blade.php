@extends('layouts.app')
@section('title')
    {{ __('messages.user.profile_details') }}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="d-flex flex-column">
            <div class="col-12">
                @include('flash::message')
                @include('layouts.errors')
                <div class="card">
                    {{ Form::open(['route' => 'update.profile.setting','method' => 'PUT', 'id' => 'profileId', 'files' => true]) }}
                    <div class="collapse show">
                        <div class="card-body p-9">
                            <div class="row mb-6">
                                {{ Form::label('Avatar', __('messages.user.avatar').':',  ['class'=> 'col-lg-4 form-label ']) }}
                                <div class="col-lg-8">
                                    <div class="mb-3" io-image-input="true">
                                        <div class="col-lg-8 mb-6">
                                            <div class="d-block">
                                                <div class="image-picker">
                                                    <div class="image previewImage" id="bgImage"
                                                         style="background-image:url('{{ $user->profile_image }}')">
                                                    </div>
                                                    <span class="picker-edit rounded-circle text-gray-500 fs-small"
                                                          title="{{__('messages.placeholder.change_profile')}}">
                                                        <label>
                                                            <i class="fa-solid fa-pen" id="profileImageIcon"></i>
                                                             <input type="file" name="profile"
                                                                    class="image-upload d-none"
                                                                    accept=".png, .jpg, .jpeg">
                                                             {{ Form::hidden('avatar_remove') }}
                                                        </label>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-6">
                                <label class="col-lg-4 form-label  required">{{ __('messages.user.full_name').':' }}</label>
                                <div class="col-lg-8">
                                    <div class="row">
                                        <div class="col-lg-6 fv-row fv-plugins-icon-container firstName">
                                            {{ Form::text('first_name', $user->first_name, ['class'=> 'form-control ', 'placeholder' => __('messages.user.full_name'), 'required']) }}
                                            <div class="fv-plugins-message-container invalid-feedback"></div>
                                        </div>
                                        <div class="col-lg-6 fv-row fv-plugins-icon-container">
                                            {{ Form::text('last_name', $user->last_name, ['class'=> 'form-control ', 'placeholder' => __('messages.user.last_name'), 'required']) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-6">
                                <label class="col-lg-4 form-label required ">{{ __('messages.user.email').':' }}</label>
                                <div class="col-lg-8 fv-row fv-plugins-icon-container">
                                    {{ Form::email('email', $user->email, ['class'=> 'form-control', 'placeholder' => __('messages.user.email'), 'required']) }}
                                </div>
                            </div>
                            <div class="row mb-6">
                                <label class="col-lg-4 form-label required ">{{ __('messages.user.contact_number').':' }}</label>
                                <div class="col-lg-8 fv-row fv-plugins-icon-container">
                                    <div>
                                        {{ Form::tel('phone_number', !empty($user->phone_number) ? '+'.$user->region_code.$user->phone_number : null,['class' => 'form-control','placeholder' => __('messages.user.contact_number'),'onkeyup' => 'if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,"")','id'=>'phoneNumber']) }}
                                        {{ Form::hidden('region_code',!empty($user->region_code) ? $user->region_code : null,['id'=>'prefix_code']) }}
                                        <span id="valid-msg"
                                              class="text-success d-none fw-400 fs-small mt-2">{{__('messages.placeholder.valid_number')}}</span>
                                        <span id="error-msg" class="text-danger d-none fw-400 fs-small mt-2"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-6">
                                <label class="col-lg-4 form-label required ">{{ __('messages.schedule.time_zone').':' }}
                                </label>
                                <div class="col-lg-8 fv-row fv-plugins-icon-container">
                                    {{ Form::select('timezone', App\Models\User::TIME_ZONE_ARRAY, $user->timezone,['class'=> 'form-control', 'placeholder' => __('messages.placeholder.select_time_zone'),'id' => 'userTimeZoneId', 'required']) }}
                                </div>
                            </div>
                        </div>
                        <div class="card-footer d-flex py-6 px-9">
                            {{ Form::submit(__('messages.common.save'),['class' => 'btn btn-primary me-2','id'=>'profileSaveBtn']) }}
                            <a href="{{ url()->previous() }}" type="reset"
                               class="btn btn-secondary">{{__('messages.common.discard')}}</a>
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@endsection
