@extends('layouts.app')
@section('title')
    {{ __('messages.currencies') }}
@endsection
@section('content')
    <div class="container-fluid">
        @include('flash::message')
        <div class="d-flex flex-column">
            <livewire:currencies-table lazy/>
        </div>
    </div>
    @include('currencies.create-modal')
    @include('currencies.edit-modal')
@endsection
