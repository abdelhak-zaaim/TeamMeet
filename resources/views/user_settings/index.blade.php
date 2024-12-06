@extends('layouts.app')
@section('title')
    {{__('messages.settings')}}
@endsection
@section('content')
    <div class="container-fluid pb-7">
        <div class="d-flex flex-column">
            @include('user_settings.setting_menu')
        </div>
    </div>
@endsection
