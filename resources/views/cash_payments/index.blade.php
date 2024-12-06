@extends('layouts.app')
@section('title')
    {{__('messages.cash_payments')}}
@endsection
@section('content')
    <div class="container-fluid">
        @include('flash::message')
        <livewire:cash-payment-table lazy/>
    </div>
    @include('cash_payments.note_modal')
@endsection
