@extends('layouts.app')
@section('title')
    Feature Availability
@endsection
@section('content')
    <div class="post d-flex flex-column-fluid">
        <div class="container">
            <div class="row justify-content-center align-items-center">
                <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                    <div class="alert alert-dismissible bg-light-danger d-flex flex-center flex-column py-10 px-10 px-lg-20 mb-10">
                        <span class="svg-icon svg-icon-5tx svg-icon-danger mb-5">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none">
                                <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="black"></rect>
                                <rect x="11" y="14" width="7" height="2" rx="1" transform="rotate(-90 11 14)"
                                      fill="black"></rect>
                                <rect x="11" y="17" width="2" height="2" rx="1" transform="rotate(-90 11 17)"
                                      fill="black"></rect>
                            </svg>
                        </span>
                        <div class="text-center">
                            <h1 class="fw-bolder mb-5">Access Denied!</h1>

                            <div class="separator separator-dashed border-danger opacity-25 mb-5"></div>

                            <div class="mb-9 text-dark">
                                {{ __('messages.access_denied') }}
                            </div>

                            <div class="d-flex flex-center flex-wrap">
                                @if(getLogInUser()->hasRole('admin'))
                                    <a href="{{ route('admin.dashboard') }}"
                                       class="btn btn-outline btn-outline-primary btn-active-primary m-2">
                                        {{ __('messages.go_to') }} {{ __('messages.dashboard.dashboard') }}
                                    </a>
                                @else
                                    <a href="{{ route('dashboard') }}"
                                       class="btn btn-outline btn-outline-primary btn-active-primary m-2">
                                       {{ __('messages.go_to') }} {{ __('messages.dashboard') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
