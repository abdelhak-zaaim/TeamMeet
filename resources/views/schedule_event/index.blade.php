@extends('layouts.app')
@section('title')
    {{__('messages.schedule_events')}}
@endsection
@section('content')
    <div class="container-fluid">
        @include('flash::message')
        @include('layouts.errors')
        <livewire:event-schedule-table lazy :eventStatus="$eventStatus" />
        @include('schedule_event.cancel_modal')
    </div>
@endsection
