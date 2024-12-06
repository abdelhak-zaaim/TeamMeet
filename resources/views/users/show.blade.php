@extends('layouts.app')
@section('title')
    {{ __('messages.user.user_details') }}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-end mb-5">
            <h1 class="mb-0">{{ __('messages.user.user_details') }}</h1>
            <div class="text-end mt-4 mt-md-0">
                @if($user->id != getLogInUserId())
                    <a href="{{route('users.edit',$user->id)}}">
                        <button type="button" class="btn btn-primary me-4 edit-button">{{ __('messages.common.edit') }}</button>
                    </a>
                @endif
                <a href="{{ route('users.index') }}">
                    <button type="button"
                            class="btn btn-outline-primary float-end">{{ __('messages.common.back') }}</button>
                </a>
            </div>
        </div>
        <div class="d-flex flex-column">
            <div class="card">
                <div class="card-body">
                    @include('users.show_fields')
                </div>
            </div>
        </div>
    </div>
@endsection
