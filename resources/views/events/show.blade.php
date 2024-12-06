@extends('layouts.app')
@section('title')
    {{ __('messages.event.show_event') }}
@endsection
@section('content')
<div class="container-fluid">
        <div class="d-flex justify-content-between align-items-end mb-5">
            <h1>@yield('title')</h1>
            <a href="{{ route('events.edit',$event->id)}}"
               class="btn btn-primary ms-auto me-4">{{ __('messages.common.edit') }}</a>
                <a href="{{route('events.index')}}"
                   class="btn btn-outline-primary float-end">{{ __('messages.common.back') }}</a>
        </div>
    <div class="d-flex flex-column">
        @include('events.show_fields')
    </div>
    @include('schedule_event.cancel_modal')
</div>
@endsection
