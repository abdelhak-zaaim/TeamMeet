@extends('layouts.app')
@section('title')
    {{ __('messages.services') }}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="d-flex flex-column">
            @include('flash::message')
            @include('layouts.errors')
            <div class="card mt-5">
                <div class="card-body">
                    {{ Form::open(['route' => 'front.service.update', 'id' => 'addServiceForm','files' => true]) }}
                        @include('fronts.services.fields')
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@endsection


