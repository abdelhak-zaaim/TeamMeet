@extends('layouts.app')
@section('title')
    {{ __('messages.faq.edit_faq') }}
@endsection
@section('content')
    <div class="container-fluid">
        @include('layouts.errors')
        <div class="d-flex flex-column">
            <div class="d-md-flex align-items-center justify-content-between mb-5">
                <h1 class="mb-0">@yield('title')</h1>
                <a href="{{ route('faqs.index') }}"
                   class="btn btn-outline-primary">{{ __('messages.common.back') }}</a>
            </div>
            <div class="card">
                <div class="card-body">
                    {{ Form::model($faq, ['route' => ['faqs.update', $faq->id], 'method' => 'put','id'=> 'editFaqForm']) }}
                    @include('fronts.faqs.fields')
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@endsection
