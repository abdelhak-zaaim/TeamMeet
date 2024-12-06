@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @php
            $styleCss = 'style';
        @endphp
        @component('mail::header', ['url' => config('app.url')])
            <h1 {{ $styleCss }}="display: inline-block">{{ getSettingData()['application_name'] }}</h1>
        @endcomponent
    @endslot
    {{-- Body --}}
    <div>
        <h2>{{ __('messages.hi') }}, <b>{{ $userName }}</b></h2>
        <p>{{ __('messages.appointment_cancelled') }}</p>
        <p>{{ __('messages.placeholder.event') }}: <b>{{ $eventName }}</b></p>
        <p>{{ __('messages.event_date') }}: <b>{{ $slotDate }}</b></p>
        <p>{{ __('messages.event_time') }}: <b>{{ $timeSlot }}</b></p>
        <p>{{ __('messages.thanks') }}</b></p>
    </div>
    {{-- Footer --}}
    @slot('footer')
        @component('mail::footer')
            <h6>© {{ date('Y') }} {{ getSettingData()['application_name'] }}.</h6>
        @endcomponent
    @endslot
@endcomponent
