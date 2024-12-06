@php
    $timeZoneName = isset(getLoginUser()->timezone) ?
            \App\Models\User::TIME_ZONE_ARRAY[getLoginUser()->timezone] : \App\Models\User::TIME_ZONE_ARRAY[getTimeZone()];
    date_default_timezone_set($timeZoneName);
    $slotTime = explode(' - ',$row->slot_time);
    $googleUserEventSchedule = \App\Models\UserGoogleEventSchedule::whereUserId($row->user_id)->whereEventScheduleId($row->id)->first();
@endphp
<div class="">
@if($row->status == 1)
    @if(($row->schedule_date == \Carbon\Carbon::now()->format('Y-m-d')) && ((strtotime(date(getUserSettingTimeFormat(getLogInUserId()))) < strtotime($slotTime[0]))))
        <a href="javascript:void(0)" data-id="{{ $row->id }}"
           class="btn-bg-light btn-sm edit-btn cancel-scheduled-event btn px-1 text-danger fs-4"
           data-bs-custom-class="tooltip-dark" data-bs-placement="bottom"
           title="{{ __('messages.schedule_event.cancel_schedule_event') }}">
            <i class="fas fa-calendar-times text-danger fs-4"></i>
        </a>
    @elseif($row->schedule_date > \Carbon\Carbon::now()->format('Y-m-d'))
        <a href="javascript:void(0)" data-id="{{ $row->id }}"
           class="btn-bg-light btn-sm edit-btn cancel-scheduled-event btn px-1 text-danger fs-4"
           data-bs-custom-class="tooltip-dark" data-bs-placement="bottom"
           title="{{ __('messages.schedule_event.cancel_schedule_event') }}">
            <i class="fas fa-calendar-times text-danger fs-4"></i>
        </a>
    @endif
@endif
@if (($row->event->event_location == \App\Models\Event::GOOGLE_MEET) && !empty($row->userGoogleEventSchedule->google_meet_link))
    <a href="{{$row->userGoogleEventSchedule->google_meet_link}}"
        class="btn px-1 text-info fs-4"
        target="_blank"><i class="fa fa-video-camera"></i>
    </a>
@endif
<a href="{{ route('scheduled-events.show', $row->id) }}" title="<?php echo __('messages.common.view') ?>"
   class="btn px-1 text-primary fs-4">
    <i class="fas fa-eye fs-4"></i>
</a>
</div>
