@extends('layouts.app')
@section('title')
    {{__('messages.dashboard')}}
@endsection
@section('content')
    <div class="container-fluid">
        @include('flash::message')
        <livewire:dashboard lazy/>
    </div>
@endsection
