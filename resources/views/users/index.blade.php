@extends('layouts.app')
@section('title')
    {{__('messages.users')}}
@endsection
@section('content')
    <div class="container-fluid">
        @include('flash::message')
        <livewire:user-table lazy/>
    </div>
@endsection
