@extends('layouts.app')
@section('title')
    {{ __('messages.event.add_event') }}
@endsection
@section('content')
    <div class="container-fluid">
        @include('flash::message')
        @include('layouts.errors')
        <div class="d-flex flex-column">
            <div class="d-md-flex align-items-center justify-content-between mb-5">
                <h1 class="mb-0">{{ __('messages.event.add_event') }}</h1>
                <a href="{{ route('events.index') }}"
                   class="btn btn-outline-primary">{{ __('messages.common.back') }}</a>
            </div>
            <div class="card">
                {{ Form::hidden('is_edit', false,['id' => 'eventIsEdit']) }}
                <div class="card-body">
                    {{ Form::open(['route' => 'events.store', 'id' => 'eventStoreForm']) }}
                    @include('events.fields')
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
    @include('events.modal')
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
@endsection


