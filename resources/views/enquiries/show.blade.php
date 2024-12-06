@extends('layouts.app')
@section('title')
    {{__('messages.enquiry.enquiry_details')}}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="d-md-flex align-items-center justify-content-between mb-5">
            <h1 class="mb-0">@yield('title')</h1>
            <a href="{{ route('enquiries.index')  }}"
               class="btn btn-outline-primary">{{ __('messages.common.back') }}</a>
        </div>
        <div class="d-flex flex-column">
            @include('enquiries.show_fields')
        </div>
    </div>
@endsection

