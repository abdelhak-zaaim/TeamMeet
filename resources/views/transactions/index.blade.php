@extends('layouts.app')
@section('title')
    {{ __('messages.transactions') }}
@endsection
@section('content')
    <div class="container-fluid">
        @include('flash::message')
        <livewire:schedule-transaction-table lazy/>
    </div>
@endsection
