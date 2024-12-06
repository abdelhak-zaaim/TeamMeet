@extends('layouts.auth')
@section('title')
    {{ __('messages.slot_schedule') }}
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
                <div class="mb-5">
                    @include('layouts.errors')
                    @include('flash::message')
                </div>
                <div>
                    @php
                        $styleCss = 'style';
                    @endphp
                    <div class="w-lg-900px bg-white rounded shadow-sm">
                        <div class="h-auto">
                            <div class="border-bottom">
                                <div class="card">
                                    <div class="d-sm-flex h-750px main-details">
                                        <div class="border-end py-7 px-7 col-lg-5 col">
                                            <div class="mb-3">
                                                <p class="fs-5 mb-2">
                                                    {{ $event->user->first_name . ' ' . $event->user->last_name }}</p>
                                                <span class="fs-1 fw-bold">{{ $event->name }}</span>
                                            </div>
                                            <div class="d-flex align-items-center mb-4">
                                                <i class="fas fa-clock me-2 fs-2 text-primary"></i>
                                                <span class="fs-4 text-primary fw-bold">{{ $event->slot_time }} min</span>
                                            </div>
                                            <div class="d-flex align-items-center mb-4">
                                                @if ($event->event_location == \App\Models\Event::IN_PERSON_MEETING)
                                                    @php($location = json_decode($event->location_meta))
                                                    <i class="fas fa-map-marker-alt me-2 fs-2 text-primary"></i>
                                                    <span class="fs-4 text-primary fw-bold">{{ $location[1] }}</span>
                                                @elseif($event->event_location == \App\Models\Event::PHONE_CALL)
                                                    @php($phoneCallNumber = json_decode($event->location_meta))
                                                    @if (count($phoneCallNumber) > 0 && !empty($phoneCallNumber[1]))
                                                        @if (!empty($phoneCallNumber[2]) && $phoneCallNumber[1] == 2)
                                                            <i class="fa-solid fa-phone me-2 fs-2 text-primary"></i>
                                                            <span
                                                                class="fs-4 text-primary fw-bold">{{ $phoneCallNumber[2] }}</span>
                                                        @else
                                                            <i class="fa-solid fa-phone  me-2 fs-2 text-primary"></i>
                                                            <span
                                                                class="fs-4 text-primary fw-bold">{{ \App\Models\Event::LOCATION_ARRAY[$event->event_location] }}</span>
                                                        @endif
                                                    @endif
                                                @else
                                                    @php($location = json_decode($event->location_meta))
                                                    @if (!empty($location))
                                                        @if (count($location) > 0 && $location[0] == 3)
                                                            <img src="{{ asset('assets/images/logo_google_meet.svg') }}"
                                                                alt="logo" width="25px" height="25px">
                                                            <span
                                                                class="fs-4 text-primary fw-bold ms-2">{{ \App\Models\Event::LOCATION_ARRAY[$location[0]] }}</span>
                                                        @else
                                                            {{ __('messages.common.n/a') }}
                                                        @endif
                                                    @endif
                                                @endif
                                            </div>
                                            <div class="d-flex align-items-start mb-4">
                                                <i class="far fa-calendar me-2 fs-2"
                                                    {{ $styleCss }}="color: #50cd89"></i>
                                                <span class="text-success fs-5 fw-bold">{{ $orgScheduleTime }}
                                                    ,<br>{{ \Carbon\Carbon::parse($scheduleDate)->dayName }},<br>{{ \Carbon\Carbon::parse($scheduleDate)->translatedFormat('jS M, Y') }}</span>
                                            </div>
                                            <div class="d-flex align-items-center mb-4">
                                                <i class="fas fa-globe-americas me-2 fs-2 text-primary"></i>
                                                <span
                                                    class="fs-5 text-primary fw-bold">{{ \App\Models\User::TIME_ZONE_ARRAY[$event->user->timezone] }}</span>
                                            </div>
                                        </div>
                                        <div class="py-7 px-7 col-md-7 col-12">
                                            {{ Form::open(['id' => 'addEventSlotScheduleForm']) }}
                                            <p class="fw-bold fs-3">{{ __('messages.enter_details') }}</p>
                                            {{ Form::hidden('user_id', $event->user->id) }}
                                            {{ Form::hidden('event_id', $event->id) }}
                                            {{ Form::hidden('schedule_date', $scheduleDate) }}
                                            {{ Form::hidden('slot_time', $orgScheduleTime) }}
                                            <div class="mb-5">
                                                {{ Form::label('name', __('messages.common.name') . ':', ['class' => 'required form-label']) }}
                                                {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => __('messages.common.name'), 'required']) }}
                                            </div>
                                            <div class="mb-5">
                                                {{ Form::label('email', __('messages.user.email') . ':', ['class' => 'required form-label']) }}
                                                {{ Form::email('email', null, ['class' => 'form-control', 'placeholder' => __('messages.user.email'), 'required']) }}
                                            </div>
                                            <p class="form-label">
                                                {{ __('messages.event.please_share_anything_that_will_help_prepare_for') }}
                                                .</p>
                                            <div class="d-flex flex-column mb-5">
                                                {{ Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => __('messages.common.description'), 'rows' => 3]) }}
                                            </div>
                                            @php($checkedPhoneCall = json_decode($event->location_meta))
                                            @if (!empty($checkedPhoneCall))
                                                @if (count($checkedPhoneCall) > 0 && !empty($checkedPhoneCall[1]))
                                                    @if ($event->event_location == \App\Models\Event::PHONE_CALL && $checkedPhoneCall[1] == 1)
                                                        {{ Form::hidden('location_meta', null, ['id' => 'eventLocationPhoneCall']) }}
                                                        <div class="mb-5 mt-5">
                                                            {{ Form::label('name', __('messages.common.phone_number') . ':', ['class' => 'required form-label']) }}
                                                            <br>
                                                            {{ Form::tel('phone_call', null, ['class' => 'form-control', 'onkeyup' => 'if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,"")', 'id' => 'phoneNumber']) }}
                                                            {{ Form::hidden('region_code', null, ['id' => 'prefix_code']) }}
                                                            <span id="valid-msg"
                                                                class="text-success d-none fw-400 fs-small mt-2">{{ __('messages.placeholder.valid_number') }}</span>
                                                            <span id="error-msg"
                                                                class="text-danger d-none fw-400 fs-small mt-2"></span>
                                                        </div>
                                                    @endif
                                                @endif
                                            @endif
                                            @if ($event->event_type == \App\Models\Event::PAID && $event->payable_amount != 0)
                                                <div class="mb-5">
                                                    {{ Form::label('payment_type', __('messages.schedule_event.payment_type') . ':', ['class' => 'required form-label']) }}
                                                    {{ Form::select('payment_type', $paymentMethod, [], ['class' => 'form-select', 'required', 'id' => 'slotPaymentType', 'placeholder' => __('messages.placeholder.select_payment_method')]) }}
                                                </div>
                                            @endif
                                            <div class="mt-6">
                                                {{ Form::button(__('messages.event.schedule_event'), ['type' => 'submit', 'class' => 'btn btn-primary w-100', 'id' => 'slotPaymentSubmitBtn']) }}
                                            </div>
                                            {{ Form::close() }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
    @push('scripts')
        <script src="//js.stripe.com/v3/" data-turbo-eval="false"></script>
        <script data-turbo-eval="false">
            let eventLocation = "{{ $event->event_location }}"
            let locationMeta = @json(json_decode($event->location_meta));
            let Paid = "{{ \App\Models\Event::PAID }}"
            let stripe = ''
            @if ($paymentType['stripe_enable'] == 1 && $paymentType['stripe_key'])
                stripe = Stripe('{{ $paymentType['stripe_key'] }}')
            @endif
            let paypal = "{{ \App\Models\EventSchedule::PAYPAL }}"
            let stripeMethod = "{{ \App\Models\EventSchedule::STRIPE }}"
            $('#slotPaymentType').select2()
        </script>
        <script src="https://checkout.razorpay.com/v1/checkout.js" data-turbolinks-eval="false" data-turbo-eval="false">
        </script>
        <script>
            let user_id = "{{ $event->user_id }}"
            let EventRazorpayURL = "{{ route('user.event.razorpay.init') }}"
            let razorpayFailed = "{{ route('user.event.razorpay.failed') }}"
            let options = {
                'key': "{{ getAdminRazorpayKey('+user_id+') }}",
                'amount': 0,
                'currency': 'INR',
                'name': "{{ getSettingData()['application_name'] }}",
                'order_id': '',
                'description': '',
                'image': "{{ asset(getSettingData()['logo']) }}", // logo here
                'callback_url': "{{ route('user.event.razorpay.success') }}",
                'prefill': {
                    'email': '', // recipient email here
                    'name': '', // recipient name here
                },
                'readonly': {
                    'name': 'true',
                    'email': 'true',
                },
                'modal': {
                    'ondismiss': function() {
                        $.ajax({
                            type: 'POST',
                            url: razorpayFailed,
                            success: function(result) {
                                if (result.url) {
                                    window.location.href = result.url
                                }
                            },
                            error: function(result) {
                                displayErrorMessage(result.responseJSON.message)
                            },
                        })
                    },
                },
            }
        </script>
    @endpush
