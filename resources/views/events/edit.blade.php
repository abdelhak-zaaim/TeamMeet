@extends('layouts.app')
@section('title')
    {{ __('messages.event.edit_event') }}
@endsection
@section('content')
    <div class="container-fluid">
        @include('flash::message')
        @include('layouts.errors')
        <div class="d-flex flex-column">
            <div class="d-md-flex align-items-center justify-content-between">
                <h1 class="mb-0">@yield('title')</h1>
                <a href="{{ route('events.index') }}"
                   class="btn btn-outline-primary">{{ __('messages.common.back') }}</a>
            </div>
            <div class="flex-lg-row-fluid">
                {{ Form::hidden('is_edit', true,['id' => 'eventIsEdit']) }}
                {{ Form::hidden('color', $event->event_color,['id' => 'colorEdit']) }}
                {{ Form::hidden('event_type', $event->event_type,['id' => 'eventTypeEdit']) }}
                {{ Form::hidden('date_range', $event->date_range,['id' => 'dateRangeEdit']) }}
                {{ Form::hidden('after_gap', $event->gap_slot,['id' => 'afterGapEdit']) }}
                {{ Form::hidden('event_id', $event->id,['id' => 'eventIdEdit']) }}
                {{ Form::hidden('default_schedule',$event->schedule_id == defaultUserSchedule() ? defaultUserSchedule() : $event->schedule_id ?? defaultUserSchedule(),['id' => 'defaultScheduleId']) }}
                <div class="mb-5">
                    <div class="pt-3 pb-0">
                        <div class="d-flex overflow-auto h-55px">
                            <ul class="nav nav-pills ">
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab"
                                       href="#editEvent">{{ __('messages.event.edit_event') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" data-bs-toggle="tab"
                                       href="#addEventSchedule">{{ __('messages.event.add_event_schedule') }}</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card">
                    @include('events.edit_fields')
                </div>
            </div>
        </div>
    </div>
    @include('events.modal')
    @include('events.schedule_name_modal')
@endsection
@section('page_js')
    <script data-turbo-eval="false">
        let PlaceApiEnable = '{{ getSettingData()['auto_detect_location_enable'] }}'
        let PlaceApiKey = ''
        if (PlaceApiEnable == 1) {
            PlaceApiKey = '{{ getSettingData()['google_place_api_key'] }}'
            let PlaceUrl = `https://maps.google.com/maps/api/js?key=${PlaceApiKey}&libraries=places`
            document.write('<script type=\'text/javascript\' src=\'' + PlaceUrl + '\'><\/script>')
        }
    </script>
    <script data-turbo-eval="false">
        if (PlaceApiKey !== '') {
            google.maps.event.addDomListener(window, 'load', initialize)

            function initialize () {
                let input = document.getElementById('shortDescLoc')
                let autocomplete = new google.maps.places.Autocomplete(input)
                autocomplete.addListener('place_changed', function () {
                    let place = autocomplete.getPlace()
                })
            }
        }
    </script>
    <script data-turbo-eval="false">
        let locationMeta = @json(json_decode($event->location_meta));
        let phoneNo = (locationMeta[0] == 2) && (locationMeta[1] == 2) ? locationMeta[2] : ''
    </script>
@endsection
