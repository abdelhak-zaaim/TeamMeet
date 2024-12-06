@extends('layouts.app')
@section('title')
    {{ __('messages.front_brands') }}
@endsection
@section('content')
    <div class="container-fluid">
        @include('flash::message')
        @include('layouts.errors')
        <livewire:brand-table lazy/>
    </div>
    @include('brands.create-modal')
    @include('brands.edit-modal')
@endsection
