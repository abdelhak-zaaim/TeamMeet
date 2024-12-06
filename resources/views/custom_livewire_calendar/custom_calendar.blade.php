@extends('layouts.auth')
@section('title')
    {{ __('messages.event.slot_calendar') }}
@endsection
@section('content')
    <div class="container livewire-calendar-container">
        <div class="row">
            <div class="d-flex flex-center flex-column flex-column-fluid py-4 calendar-container">
                <div class="w-100 rounded">
                    <div>
                        @livewire('custom-calendars', ['event' => $event])
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection



