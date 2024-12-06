@extends('layouts.app')
@section('title')
    {{ __('messages.subscription_transactions') }}
@endsection
@section('content')
    <div class="container-fluid">
        @include('flash::message')
        <livewire:subscription-transaction-table lazy/>
    </div>
@endsection
