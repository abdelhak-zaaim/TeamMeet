@extends('layouts.app')
@section('title')
    {{ __('messages.subscribers') }}
@endsection
@section('content')
    <div class="container-fluid">
        @include('flash::message')
        <livewire:subscribers-table lazy/>
    </div>
@endsection
