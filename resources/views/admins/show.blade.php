@extends('layouts.app')
@section('title')
    {{ __('messages.admin.admin_details') }}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-end mb-5">
            <h1 class="mb-0">{{ __('messages.admin.admin_details') }}</h1>
            <div class="text-end mt-4 mt-md-0">
                <a href="{{route('admins.edit',$admin->id)}}">
                    <button type="button" class="btn btn-primary me-4 edit-button">{{ __('messages.common.edit') }}</button>
                </a>
                <a href="{{ route('admins.index') }}">
                    <button type="button"
                            class="btn btn-outline-primary float-end">{{ __('messages.common.back') }}</button>
                </a>
            </div>
        </div>
        <div class="d-flex flex-column">
            <div class="card">
                <div class="card-body">
                    @include('admins.show_fields')
                </div>
            </div>
        </div>
    </div>
@endsection
