@extends('layouts.app')
@section('title')
    {{ __('messages.about_us.about_us') }}
@endsection
@section('content')
    <div class="container-fluid">
        @include('layouts.errors')
        @include('flash::message')
        <div class="d-flex flex-column">
            <div class="card">
                {{ Form::hidden('about_us_data',$aboutUs['about_us_description'] ?? null,['id' => 'aboutUsData']) }}
                <div class="card-body">
                    {{ Form::open(['route' => 'about.us.update', 'id' => 'aboutUsForm']) }}
                        @include('fronts.about_us.fields')
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@endsection
