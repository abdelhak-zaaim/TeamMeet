@extends('fronts.layouts.app')
@section('front-title')
    {{ __('messages.terms_conditions') }}
@endsection
@section('front-content')
    <section>
        <div class="container p-t-100 padding-top-0">
            <div class="mt-100">{!! $frontCMSSettings['terms_conditions'] !!}</div>
        </div>
    </section>
@endsection
