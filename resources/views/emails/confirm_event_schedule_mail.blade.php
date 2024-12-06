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
        <h2>Hi, <b>{{ $name }}</b></h2>
        <p>A new event has been scheduled.</p>
        <p>Event: <b>{{ $eventName }}</b></p>
        @if(!empty($googleMeetLink))
            <p>Location: <b>This is a Google Meet web conference. </b><a href="{{ $googleMeetLink }}" target="_blank">Join
                    now</a></p>
        @endif
        <p>Invitee: <b>{{ $name }}</b></p>
        <p>Invitee Email: <b>{{ $email }}</b></p>
        <p>Scheduled Event Date: <b>{{ $eventScheduleDate }}</b></p>
        <p>Scheduled Event Time: <b>{{ $eventScheduleTime }}</b></p>
        <p {{ $styleCss }}="text-align: center;"><a href="{{ $confirmScheduleEventUrl }}"
        {{ $styleCss }}="
        padding: 7px 15px;text-decoration: none;font-size: 14px;background-color: #50cd89;font-weight: 500;border: none;border-radius: 8px;color: white;text-align: center;
        ">Go To Scheduled Event Page</a></p>
        <p {{ $styleCss }}="text-align: center"><a href="{{ $cancelScheduleEventUrl }}"
        {{ $styleCss }}="
        padding: 7px 15px;text-decoration: none;font-size: 14px;background-color: #e5153b;font-weight: 500;border: none;border-radius: 8px;color: white;text-align: center;margin-top: 10px;
        ">Cancel Scheduled Event</a></p>
    </div>
    {{-- Footer --}}
    @slot('footer')
        @component('mail::footer')
            <h6>© {{ date('Y') }} {{ getSettingData()['application_name'] }}.</h6>
        @endcomponent
    @endslot
@endcomponent
