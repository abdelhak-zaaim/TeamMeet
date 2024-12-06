@extends('layouts.app')
@section('title')
    {{__('messages.personal_experiences')}}
@endsection
@section('content')
    <div class="container-fluid">
        @include('flash::message')
        <livewire:personal-experience-table lazy/>
    </div>
    @include('personal_experiences.create_model')
    @include('personal_experiences.edit_modal')
@endsection
