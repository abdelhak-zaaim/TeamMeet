@extends('layouts.app')
@section('title')
    {{ __('messages.faqs') }}
@endsection
@section('content')
    <div class="container-fluid">
        @include('flash::message')
        @include('layouts.errors')
        <div class="d-flex flex-column">
            <livewire:faq-table lazy/>
        </div>
    </div>
@endsection
