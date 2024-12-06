
<div class="align-items-center justify-content-between mt-md-0 mt-3 timeSlot">
    <div class="d-flex flex-xs-column align-items-center mb-3 add-slot">
        <div class="d-inline-block">
            {{ Form::select('from_time[' . $day . '][]', getConstTimeArr(), isset($weekDaySlot) ? \Carbon\Carbon::parse($weekDaySlot->from_time)->format(getUserSettingTimeFormat(getLogInUserId())) : $timeArr[array_key_first($timeArr)], ['class' => 'form-select startTimeSlot time', 'disabled' => false]) }}
        </div>
        <span class="small-border">-</span>
        <div class="d-inline-block">
            {{ Form::select('to_time[' . $day . '][]', getConstTimeArr(), isset($weekDaySlot) ? \Carbon\Carbon::parse($weekDaySlot->to_time)->format(getUserSettingTimeFormat(getLogInUserId())) : end($timeArr), ['class' => 'form-select endTimeSlot time', 'disabled' => false]) }}
        </div>
        <a href="javascript:void(0)" class="deleteBtn btn px-2 text-danger fs-3 pe-0">
            <i class="fa-solid fa-trash"></i>
        </a>
    </div>
    <span class="error-msg text-danger"></span>
</div>
