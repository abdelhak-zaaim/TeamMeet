@extends('layouts.app')
@section('title')
    {{ __('messages.front_testimonial.edit_front_testimonial') }}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="d-flex flex-column">
            @include('layouts.errors')
            <div class="d-md-flex align-items-center justify-content-between mb-5">
                <h1 class="mb-0">@yield('title')</h1>
                <a href="{{ route('front-testimonials.index')  }}"
                   class="btn btn-outline-primary">{{ __('messages.common.back') }}</a>
            </div>
            <div class="card">
                <div class="card-body">
                    {{ Form::open(['route' => ['front-testimonials.update', $frontTestimonial->id], 'method' => 'put','files' => 'true','id'=>'editFrontTestimonialForm']) }}
                    @include('fronts.front_testimonials.edit_fields')
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@endsection
