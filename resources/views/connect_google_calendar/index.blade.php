@extends('layouts.app')
@section('title')
    {{ __('messages.setting.connect_google_calendar') }}
@endsection
@section('content')
    <div class="container-fluid">
        @include('flash::message')
        <div class="d-flex flex-column">
            @if(getLogInUser()->hasRole('user'))
                @if(!isset($data['checkTimeZone']->timezone))
                    <div class="py-5">
                        <div class="d-flex align-items-center rounded py-5 px-5 bg-light-danger">
                        <span class="svg-icon svg-icon-3x svg-icon-danger me-5">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                 viewBox="0 0 24 24" fill="none">
                                <rect opacity="0.3" x="2" y="2" width="20" height="20"
                                      rx="10" fill="black"></rect>
                                <rect x="11" y="14" width="7" height="2" rx="1"
                                      transform="rotate(-90 11 14)" fill="black"></rect>
                                <rect x="11" y="17" width="2" height="2" rx="1"
                                      transform="rotate(-90 11 17)" fill="black"></rect>
                            </svg>
                        </span>
                            <div class="text-gray-700 text-danger fw-bold fs-6">Note: You must need to set your timezone
                                before integrating Google Calendar.
                            </div>
                        </div>
                    </div>
                @endif
            @endif
            <div class="card mb-5 mb-xl-10">
                @if(!$data['googleCalendarIntegrationExists'])
                    <div class="card-header border-0 justify-content-center cursor-pointer">
                        <div class="card-title m-0">
                            @if(getLogInUser()->hasRole('user'))
                                @if(!isset(getLogInUser()->timezone))
                                    <a href="{{ route('googleAuth') }}" data-turbo="false"
                                       class="btn btn-primary m-0 disabled">{{ __('messages.setting.connect_your_google_calendar') }}</a>
                                @else
                                    <a href="{{ route('googleAuth') }}" data-turbo="false"
                                       class="btn btn-primary m-0">{{ __('messages.setting.connect_your_google_calendar') }}</a>
                                @endif
                            @else
                                <a href="{{ route('googleAuth') }}" data-turbo="false"
                                   class="btn btn-primary m-0">{{ __('messages.setting.connect_your_google_calendar') }}</a>
                            @endif
                        </div>
                    </div>
                @else
                    <div class="card-header border-0">
                        <div class="card-title m-0">
                            <span class="fs-5 fw-bold mt-3">{{ __('messages.setting.select_your_calendars_from_google_calendar_in_which_you_want_to_create_the_appointments') }}.</span>
                        </div>
                    </div>
                    <div class="row">
                        {{ Form::open(['id' => 'googleCalendarForm']) }}
                        <div class="col-12">
                            <div class="card-body p-12">
                                @foreach($data['googleCalendarLists'] as $key => $googleCalendarList)
                                    <div class="row mb-3">
                                        <div class="d-flex align-items-center">
                                            {{ Form::checkbox('google_calendar[]', $googleCalendarList->id, \App\Models\EventGoogleCalendar::whereGoogleCalendarListId($googleCalendarList->id)->exists(), ['class' => 'form-check-input me-5 google-calendar','id' => 'checkedId'.($key+1) ]) }}
                                            <label class=" cursor-pointer"
                                                   for="checkedId{{ $key+1 }}">
                                                <span>{{ $googleCalendarList->calendar_name }}</span>
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                                <div class="pt-5 mt-5">
                                    <div class="d-flex flex-sm-wrap flex-wrap">
                                        {{ Form::submit(__('messages.common.save'),['class' => 'btn btn-primary me-2 mb-md-0 mb-2','id'=>'googleCalendarSubmitBtn']) }}
                                        <a id="syncGoogleCalendar"
                                           class="me-2 btn btn-primary me-2 mb-md-0 mb-2">
                                            {{ __('messages.setting.sync_your_google_calendar') }}
                                        </a>
                                        <a href="{{ route('disconnectCalendar.destroy') }}" data-turbo="false"
                                           class="btn btn-danger m-0">{{ __('messages.setting.disconnect_your_google_calendar') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{ Form::close() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
