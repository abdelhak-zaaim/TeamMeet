@extends('layouts.app')
@section('title')
    {{__('messages.subscription_plans')}}
@endsection
@section('content')
    <div class="container-fluid ">
        @include('flash::message')
        <livewire:subscription-plan-table lazy/>
    </div>
@endsection
