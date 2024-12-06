@extends('layouts.app')
@section('title')
    {{ __('messages.schedule_event.scheduled_event_details') }}
@endsection
@section('content')
    <div class="container-fluid">
        @include('flash::message')
        @include('layouts.errors')
        <div class="d-flex justify-content-between align-items-end mb-5">
            <h1 class="mb-0">@yield('title')</h1>
            <div class="text-end mt-4 mt-md-0">
                <a href="{{ route('scheduled-events.index') }}">
                    <button type="button" class="btn btn-outline-primary float-end">{{ __('messages.common.back') }}</button>
                </a>
            </div>
        </div>
        <div class="d-flex flex-column">
            <div class="card">
                <div class="card-body">
                    @include('schedule_event.show_fields')
                </div>
            </div>
        </div>
    </div>  
@endsection



