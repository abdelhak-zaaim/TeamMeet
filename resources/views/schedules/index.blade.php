@extends('layouts.app')
@section('title')
    {{ __('messages.schedules') }}
@endsection
@section('content')
    <div class="container-fluid">
        @include('flash::message')
        <div class="d-flex flex-column pt-4">
            {{ Form::hidden('default_schedule',defaultUserSchedule(),['id' => 'defaultScheduleId']) }}
            <div class="d-md-flex align-items-center justify-content-between w-100 mb-3">
                <div style="width: 250px;" class=" mt-3">
                    {{ Form::select('schedule_name',$scheduleNameArr,null,['class' => 'form-select', 'id' => 'scheduleNameId']) }}
                </div>
                <a class="btn btn-primary add-schedule-name mt-3" href="javascript:void(0)">
                    {{ __('messages.schedule.add_schedule') }}</a>
            </div>
            <div class="maincard-section p-0">
                @include('schedules.schedule_listing')
            </div>
        </div>
        @include('schedules.create_modal')
        @include('schedules.edit_modal')
    </div>
@endsection
