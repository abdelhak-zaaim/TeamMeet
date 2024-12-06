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
        <h2>{{ __('messages.hi')}}, <b>{{ $name }}</b></h2>
        <p>{{ __('messages.success_message.schedule_event_cancle') }}</p>
        <p>{{ __('messages.event_date') }}: <b>{{ $eventScheduleDate }}</b></p>
        <p>{{ __('messages.event_time') }}: <b>{{ $eventScheduleTime }}</b></p>
    </div>
    {{-- Footer --}}
    @slot('footer')
        @component('mail::footer')
            <h6>© {{ date('Y') }} {{ getSettingData()['application_name'] }}.</h6>
        @endcomponent
    @endslot
@endcomponent
