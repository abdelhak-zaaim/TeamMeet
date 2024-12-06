@extends('fronts.layouts.app')
@section('front-title')
    {{ __('messages.faqs') }}
@endsection
@section('front-css')
    <link href="{{ asset('front/css/contact.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/css/front/custom.css') }}">
@endsection
@section('front-content')
    <div class="contact-page">
        <!-- start services section -->
        <section class="contact-info-section p-t-100 p-b-100">
            <div class="container">
                <h2 class="m-b-60 max-w-620 text-center mx-auto">{{ __('messages.faqs') }}</h2>
                <div class="row justify-content-center p-t-60">
                    <div class="col-12">
                        <div class="reason-content">
                            <div class="accordion" id="accordionExample">
                                @foreach($faqs as $key => $faq)
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="heading{{ $key+1 }}">
                                            <button class="text-green accordion-button px-0 pt-0 box-shadow-none"
                                                    type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapse{{ $key+1 }}"
                                                    aria-expanded="true"
                                                    aria-controls="collapseOne">
                                                {{ $faq->question }}
                                            </button>
                                        </h2>
                                        <div id="collapse{{ $key+1 }}" class="accordion-collapse collapse"
                                             aria-labelledby="heading{{ $key+1 }}" data-bs-parent="#accordionExample">
                                            <div class="accordion-body px-0">
                                                <p class="fs-6 text-secondary fw-light mb-0">
                                                    {{ $faq->answer }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="text-center mt-5">
                            <h3 class="mb-35 font-rubik">{{ __('messages.web.dont_find_your_answer') }}</h3>
                            <a href="{{ route('contact-us') }}"
                               class="btn btn-primary">{{ __('messages.contact_us') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
