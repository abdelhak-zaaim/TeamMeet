@extends('layouts.app')
@section('title')
    {{ __('messages.enquiries') }}
@endsection
@section('content')
    <div class="container-fluid">
        @include('flash::message')
        @include('layouts.errors')
        <livewire:enquiry-table lazy/>
    </div>
@endsection
