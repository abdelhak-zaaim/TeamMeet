@extends('layouts.app')
@section('title')
    {{ __('messages.front_testimonials') }}
@endsection
@section('content')
    <div class="container-fluid">
        @include('flash::message')
        @include('layouts.errors')
        <div class="d-flex flex-column">
            <livewire:front-testimonial-table lazy/>
        </div>
    </div>
@endsection
