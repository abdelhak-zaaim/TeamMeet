@extends('layouts.app')
@section('title')
    {{__('messages.setting.credentials') }}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="d-flex flex-column">
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="aoverview" role="tabpanel">
                    @include('setting.setting_menu')
                    <div class="card mb-5 mb-xl-10 border-0">
                        <div class="card-body">
                            {{ Form::open(['route' => 'setting.credential.update', 'id'=>'credentialsSettings', 'class'=>'form']) }}
                            {{ Form::hidden('sectionName', $sectionName) }}
                            <div class="row">
                                {{--  STRIPE --}}
                                <div class="row">
                                    <div class="col-lg-1 col-form-label fw-bold fs-6">
                                        {{ Form::label('stripe_checkbox_btn', __('messages.setting.stripe'). ' :', ['class' => 'form-label']) }}
                                    </div>
                                    <div class="col-lg-8 mt-3">
                                        <div class="form-check form-switch form-switch-sm col-6">
                                            <div class="fv-row d-flex align-items-center">
                                                {{ Form::checkbox('stripe_checkbox_btn', 1, getSettingData()['stripe_checkbox_btn'] ?? 0,['class' => 'form-check-input  me-5', 'id' => 'stripeCheckboxBtn']) }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-none stripe_div row">
                                    <div class="form-group col-sm-6 mb-5">
                                        {{ Form::label('stripe_key', __('messages.setting.stripe_key').':', ['class' => 'form-label required ']) }}
                                        {{ Form::text('stripe_key', getSettingData()['stripe_key'] ?? null, ['class' => 'form-control'  , 'placeholder' => __('messages.setting.stripe_key'), 'id' => 'stripeKey' ]) }}
                                    </div>
                                    <div class="form-group col-sm-6 mb-5">
                                        {{ Form::label('stripe_secret', __('messages.setting.stripe_secret').':', ['class' => 'form-label required ']) }}
                                        {{ Form::text('stripe_secret', getSettingData()['stripe_secret'] ?? null, ['class' => 'form-control',  'placeholder' => __('messages.setting.stripe_secret') , 'id' =>'stripeSecret']) }}
                                    </div>
                                </div>

                                {{--  PAYPAL --}}

                                <div class="row">
                                    <div class="col-lg-1 col-form-label fw-bold fs-6">
                                        {{ Form::label('paypal_checkbox_btn', __('messages.setting.paypal'). ' :', ['class' => 'form-label']) }}
                                    </div>
                                    <div class="col-lg-8 mt-3">
                                        <div class="form-check form-switch form-switch-sm col-6">
                                            <div class="fv-row d-flex align-items-center">
                                                {{ Form::checkbox('paypal_checkbox_btn', 1, getSettingData()['paypal_checkbox_btn'] ?? 0,['class' => 'form-check-input  me-5', 'id' => 'paypalCheckboxBtn']) }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-none paypal_div row">
                                    <div class="form-group col-sm-6 mb-5">
                                        {{ Form::label('paypal_client_id', __('messages.setting.paypal_client_id').':', ['class' => 'form-label required ']) }}
                                        {{ Form::text('paypal_client_id', getSettingData()['paypal_client_id'] ?? null, ['class' => 'form-control',  'placeholder' => __('messages.setting.paypal_client_id'), 'id' =>'paypalClientId']) }}
                                    </div>
                                    <div class="form-group col-sm-6 mb-5">
                                        {{ Form::label('paypal_secret', __('messages.setting.paypal_secret').':', ['class' => 'form-label required ']) }}
                                        {{ Form::text('paypal_secret', getSettingData()['paypal_secret'] ?? null, ['class' => 'form-control',  'placeholder' => __('messages.setting.paypal_secret'), 'id' => 'paypalSecret']) }}
                                    </div>
                                    <div class="form-group col-sm-6 mb-5">
                                        {{ Form::label('paypal_mode', __('messages.setting.paypal_mode').':', ['class' => 'form-label required ']) }}
                                        {{ Form::text('paypal_mode', getSettingData()['paypal_mode'] ?? null, ['class' => 'form-control',  'placeholder' => __('messages.setting.paypal_mode') , 'id' => 'paypalMode']) }}
                                    </div>
                                </div>
                                {{--  PAYPAL --}}

                                {{-- Paystack --}}
                                <div class="row">
                                    <div class="col-lg-1 col-form-label fw-bold fs-6">
                                        {{ Form::label('paystack_checkbox_btn', __('messages.setting.paystack'). ' :', ['class' => 'form-label']) }}
                                    </div>
                                    <div class="col-lg-8 mt-3">
                                        <div class="form-check form-switch form-switch-sm col-6">
                                            <div class="fv-row d-flex align-items-center">
                                                {{ Form::checkbox('paystack_checkbox_btn', 1, getSettingData()['paystack_checkbox_btn'] ?? 0,['class' => 'form-check-input  me-5', 'id' => 'paystackCheckboxBtn']) }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-none paystack_div row">
                                    <div class="form-group col-sm-6 mb-5">
                                        {{ Form::label('paystack_key', __('messages.setting.paystack_key').':', ['class' => 'form-label required ']) }}
                                        {{ Form::text('paystack_key', getSettingData()['paystack_key'] ?? null, ['class' => 'form-control'  , 'placeholder' => __('messages.setting.paystack_key'), 'id' => 'paystackKey' ]) }}
                                    </div>
                                    <div class="form-group col-sm-6 mb-5">
                                        {{ Form::label('paystack_secret', __('messages.setting.paystack_secret').':', ['class' => 'form-label required ']) }}
                                        {{ Form::text('paystack_secret', getSettingData()['paystack_secret'] ?? null, ['class' => 'form-control',  'placeholder' => __('messages.setting.paystack_secret') , 'id' =>'paystackSecret']) }}
                                    </div>
                                </div>

                                {{-- RazorPay --}}
                                <div class="row">
                                    <div class="col-lg-1 col-form-label fw-bold fs-6">
                                        {{ Form::label('razorpay_checkbox_btn', __('messages.setting.razorpay'). ' :', ['class' => 'form-label']) }}
                                    </div>
                                    <div class="col-lg-8 mt-3">
                                        <div class="form-check form-switch form-switch-sm col-6">
                                            <div class="fv-row d-flex align-items-center">
                                                {{ Form::checkbox('razorpay_checkbox_btn',1,getSettingData()['razorpay_checkbox_btn'] ?? 0,['class' => 'form-check-input me-5', 'id' => 'razorpayCheckboxBtn']) }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-none razorpay_div row">
                                    <div class="form-group col-sm-6 mb-5">
                                        {{ Form::label('razorpay_key', __('messages.setting.razorpay_key').':', ['class' => 'form-label required']) }}
                                        {{ Form::text('razorpay_key', getSettingData()['razorpay_key'] ?? null, ['class' => 'form-control', 'placeholder' => __('messages.setting.razorpay_key'), 'id' => 'razorpayKey']) }}
                                    </div>
                                    <div class="form-group col-sm-6 mb-5">
                                        {{ Form::label('razorpay_secret', __('messages.setting.razorpay_secret').':', ['class' => 'form-label required']) }}
                                        {{ Form::text('razorpay_secret', getSettingData()['razorpay_secret'] ?? null, ['class' => 'form-control', 'placeholder' => __('messages.setting.razorpay_secret'), 'id' => 'razorpaSecret']) }}
                                    </div>
                                </div>

                            </div>
                            <div class="card-footer d-flex pt-6 p-0">
                                <button type="submit" class="btn btn-primary"
                                        id="credentialSettingBtn">{{ __('messages.common.save') }}</button>
                            </div>
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
