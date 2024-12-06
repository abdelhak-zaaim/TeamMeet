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
        <h2>Hi, <b>{{ $loginUserName }}</b></h2>
        <p>A new event has been scheduled.</p>
        <p>Event: <b>{{ $eventName }}</b></p>
        <p>Invitee: <b>{{ $name }}</b></p>
        <p>Invitee Email: <b>{{ $email }}</b></p>
        <p>Scheduled Event Date: <b>{{ $eventScheduleDate }}</b></p>
        <p>Scheduled Event Time: <b>{{ $eventScheduleTime }}</b></p>
    </div>
    {{-- Footer --}}
    @slot('footer')
        @component('mail::footer')
            <h6>© {{ date('Y') }} {{ getSettingData()['application_name'] }}.</h6>
        @endcomponent
    @endslot
@endcomponent
