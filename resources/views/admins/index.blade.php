@extends('layouts.app')
@section('title')
    {{__('messages.admins')}}
@endsection
@section('content')
    <div class="container-fluid">
        @include('flash::message')
        <livewire:admin-table lazy/>
    </div>
@endsection
