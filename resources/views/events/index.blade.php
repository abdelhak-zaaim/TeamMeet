@extends('layouts.app')
@section('title')
    {{ __('messages.events') }}
@endsection
@section('content')
    <div class="container-fluid">
        @include('flash::message')
        {{-- <div class="d-flex flex-column"> --}}
            {{-- @livewire('events') --}}
            <livewire:events lazy/>
        {{-- </div> --}}
    </div>
@endsection
