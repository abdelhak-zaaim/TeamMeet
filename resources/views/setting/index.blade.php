@extends('layouts.app')
@section('title')
    {{__('messages.settings')}}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="d-flex flex-column">
            @include('setting.setting_menu')
        </div>
    </div>
@endsection
