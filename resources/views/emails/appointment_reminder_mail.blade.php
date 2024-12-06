@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            <h1 style="display: inline-block">{{ getSettingData()['application_name'] }}</h1>
        @endcomponent
    @endslot
    {{-- Body --}}
    <div>
        <h2>{{ __('messages.dear') }}, <b>{{ $name }}</b></h2>
        <p>{{ __('messages.appointment_reminder') }}</p>
        <p>{{ __('messages.appointment_reminder2') }} <b>{{ $eventName }}</b> {{ __('messages.appointment_reminder3') }} <b>{{ $eventScheduleDate }}</b> {{ __('messages.and')}} <b>{{ $eventScheduleTime }}</b>.</p>
        <p>{{ __('messages.appointment_reminder4') }}</p>
    </div>
    {{-- Footer --}}
    @slot('footer')
        @component('mail::footer')
            <h6>© {{ date('Y') }} {{ getSettingData()['application_name'] }}.</h6>
        @endcomponent
    @endslot
@endcomponent
