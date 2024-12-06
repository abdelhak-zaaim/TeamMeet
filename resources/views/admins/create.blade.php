@extends('layouts.app')
@section('title')
    {{__('messages.admin.add_admin')}}
@endsection
@section('content')
    <div class="container-fluid">
        @include('flash::message')
        @include('layouts.errors')
        <div class="d-flex flex-column">
            <div class="d-md-flex align-items-center justify-content-between mb-5">
                <h1 class="mb-0">@yield('title')</h1>
                <a href="{{ route('admins.index')  }}"
                   class="btn btn-outline-primary">{{ __('messages.common.back') }}</a>
            </div>
            <div class="card">
                <div class="card-body">
                    {{ Form::open(['route' => 'admins.store','files' => true, 'id' => 'createUserForm']) }}
                    @include('admins.fields')
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@endsection

