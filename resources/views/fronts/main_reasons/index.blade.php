@extends('layouts.app')
@section('title')
    {{ __('messages.main_reasons') }}
@endsection
@section('content')
<div class="container-fluid">
    <div class="d-flex flex-column">
        @include('flash::message')
        @include('layouts.errors')
        <div class="card">
            <div class="card-body">
                {{ Form::open(['route' => 'main.reasons.update', 'id' => 'addMainReasonForm','files' => true]) }}
                    @include('fronts.main_reasons.fields')
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
@endsection
