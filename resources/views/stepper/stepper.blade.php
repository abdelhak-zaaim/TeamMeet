@extends('stepper.app')
@section('title')
    {{ __('messages.customer_on_board') }}
@endsection
@section('content')
    <div class="d-flex flex-center flex-column py-5">
        <div class="text-center">
            <a href="#" class="mb-12">
                <img src="{{ asset(getSettingData()['logo']) }}" class="logo object-cover" alt="logo"/>
            </a>
        </div>
    </div>
    <div class="container-fluid mb-5 mt-5">
        <div class="max-w-900 mx-auto">
            <div class="card">
                <div class="card-header align-items-center justify-content-center">
                    <h3 class="card-title w-100 text-center">{{ __('messages.welcome_to_infycal') }}!</h3>
                    <div class="">
                        <p class="text-center">{{ __('messages.web.we_take_the_work_out_of_connecting_with_others_so') }}
                            {{ __('messages.web.you_can_accomplish_more') }}.</p>
                    </div>
                </div>
                <div class="card-body">
                    <ul class="nav nav-pills mb-5 align-items-center justify-content-center" id="pills-tab"
                        role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link {{ empty(getLogInUser()->step) ? 'active' : '' }}"
                                    id="pills-domain-tab"
                                    data-bs-toggle="pill"
                                    data-bs-target="#pills-domain" type="button" role="tab" aria-controls="pills-domain"
                                    aria-selected="true">{{ __('messages.schedule.domain_url') }}
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link {{ !empty(getLogInUser()->step) && getLogInUser()->step == 1 ? 'active' : '' }}"
                                    id="pills-profile-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-schedule" type="button" role="tab"
                                    aria-controls="pills-schedule"
                                    aria-selected="false">{{ __('messages.schedule.time_schedule') }}
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link {{ !empty(getLogInUser()->step) && getLogInUser()->step == 2 ? 'active' : '' }}"
                                    id="pills-personal-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-personal" type="button" role="tab"
                                    aria-controls="pills-personal"
                                    aria-selected="false">{{ __('messages.personal_experiences') }}
                            </button>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade {{ empty(getLogInUser()->step) ? 'active show' : '' }}"
                             id="pills-domain"
                             role="tabpanel"
                             aria-labelledby="pills-domain-tab">
                            <form id="frontCustomerOnBoardForm1">
                                @include('stepper.domain_url')
                                <div class="d-flex justify-content-end mt-7">
                                    <button type="submit"
                                            class="btn btn-primary">{{ __('messages.web.continue') }}</button>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade {{ !empty(getLogInUser()->step) && getLogInUser()->step == 1 ? 'active show' : '' }}"
                             id="pills-schedule" role="tabpanel" aria-labelledby="pills-schedule-tab">
                            <form id="frontCustomerOnBoardForm2">
                                @include('stepper.time_schedule')
                                <div class="d-flex justify-content-end mt-7">
                                    <button type="submit"
                                            class="btn btn-primary">{{ __('messages.web.continue') }}</button>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade {{ !empty(getLogInUser()->step) && getLogInUser()->step == 2 ? 'active show' : '' }}"
                             id="pills-personal" role="tabpanel" aria-labelledby="pills-personal-tab">
                            <form id="frontCustomerOnBoardForm3">
                                @include('stepper.personal_experience')
                                <div class="d-flex justify-content-end mt-7">
                                    <button type="submit"
                                            class="btn btn-primary">{{ __('messages.web.continue') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        let userRole = "{{ getLogInUser()->hasRole('user') }}"
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jstimezonedetect/1.0.4/jstz.min.js"></script>
    <script src="{{ mix('assets/js/front/customer-on-board.js') }}"></script>
@endsection
