@php(
    $scheduleName = getLogInUser()->schedule()->where('id', $scheduleId)->first()->schedule_name
)
<div>
    <div class="d-flex mt-3 mb-5 align-items-center">
        <div class="ms-6 me-5">
            <h2 class="fs-4">{{ $scheduleName }}</h2>
            @if (defaultUserSchedule() == $scheduleId)
                <span class=""><i class="fa fa-star me-2 fs-3"
                        style="color: #f2ce0e"></i>{{ __('messages.schedule.default_schedule') }}</span>
            @endif
        </div>
        @if (defaultUserSchedule() != $scheduleId)
            <div class="d-flex mb-3 me-6">
                <a href="javascript:void(0)" data-id="{{ $scheduleId }}"
                    class="btn px-2 text-primary fs-3 ps-0 edit-schedule" title="Edit">
                    <i class="fa-solid fa-pen-to-square"></i>
                </a>
                <a href="javascript:void(0)" data-id="{{ $scheduleId }}"
                    class="btn px-2 text-danger fs-3 pe-0 delete-schedule" title="{{ __('messages.common.delete') }}">
                    <i class="fa-solid fa-trash"></i>
                </a>
            </div>
        @endif
    </div>

    @php($weekDays = App\Models\UserSchedule::WEEKDAY_FULL_NAME)
    @foreach (App\Models\UserSchedule::WEEKDAY as $day => $shortWeekDay)
        @php($isValid = isset($scheduleWeekDays) && $scheduleWeekDays->where('day_of_week', '=', $day)->count() != 0)
        @php($clinicScheduleDay = $scheduleWeekDays->where('day_of_week', '=', $day)->first())
        <div class="">
            <div class="weekly-content" data-day="{{ $day }}">
                <div class="d-flex w-100 align-items-center position-relative">
                    <div class="d-flex flex-md-row flex-column w-100 weekly-row align-items-md-center">
                        <div class="form-check  mb-0 checkbox-content d-flex align-items-center">
                            <input id="chkShortWeekDay_{{ $shortWeekDay }}" class="form-check-input" type="checkbox"
                                value="{{ $day }}" name="checked_week_days[]"
                                @if (isset($scheduleWeekDays)) @if ($isValid)
                                   checked="checked"
                                   @else
                                   disabled @endif
                        @elseif(!$loop->last && $clinicScheduleDay) checked="checked" @else disabled @endif>
                        <label class="form-check-label ms-3" for="chkShortWeekDay_{{ $shortWeekDay }}">
                            <span
                                class="fs-5 fw-bold d-md-block d-none">{{ strtoupper(__('messages.common.' . strtolower($shortWeekDay))) }}</span>
                        </label>
                    </div>
                    @if (isset($scheduleWeekDays))
                        @if (!$isValid)
                            <div class="unavailable-time mx-2">{{ __('messages.schedule.unavailable') }}</div>
                        @endif
                    @elseif($loop->last || !$clinicScheduleDay)
                        <div class="unavailable-time mx-2">{{ __('messages.schedule.unavailable') }}</div>
                    @endif
                    <div class="session-times mt-3">
                        @if ($clinicScheduleDay)
                            @if (isset($scheduleWeekDays) && $scheduleWeekDays->count())
                                @foreach ($scheduleWeekDays->where('day_of_week', $day) as $weekDaySlot)
                                    @include('events.slot', [
                                        'timeArr' => getConstTimeArr(),
                                        'day' => $day,
                                        'weekDaySlot' => $weekDaySlot,
                                    ])
                                @endforeach
                            @else
                                @if (!$loop->last)
                                    @if (!isset($scheduleWeekDays) || $isValid)
                                        @include('events.slot', [
                                            'timeArr' => getConstTimeArr(),
                                            'day' => $day,
                                        ])
                                    @endif
                                @else
                                    <div class="session-time"></div>
                                @endif
                            @endif
                        @endif
                    </div>
                </div>
                @if ($clinicScheduleDay)
                    <div class="weekly-icon position-absolute end-0 d-flex align-items-center">
                        <a href="javascript:void(0)" class="add-session-time btn px-2 text-gray-600 fs-2"
                            data-bs-toggle="tooltip" title="{{ __('messages.common.add') }}">
                            <i class="fa-solid fa-plus"></i>
                        </a>
                        <div class="dropdown d-flex align-items-center">
                            <button class="btn dropdown-toggle copy-days-btn ps-2 pe-0 hide-arrow" type="button"
                                id="dropdownCopyMenu-{{ $day }}" data-bs-toggle="dropdown"
                                aria-expanded="false" data-bs-auto-close="outside">
                                <i class="fa-solid fa-copy text-gray-600 fs-2"></i>
                            </button>
                            <div class="dropdown-menu copy-menu py-0 rounded-10 min-width-220"
                                aria-labelledby="dropdownCopyMenu-{{ $day }}">
                                <div class="p-5 menu-content">
                                    @foreach ($weekDays as $weekDayKey => $weekDay)
                                        @if ($day != $weekDayKey)
                                            <div
                                                class="mb-5 form-check ps-0 d-flex align-items-center justify-content-between copy-label">
                                                <label class="form-check-label text-gray-900"
                                                    for="chkCopyDay_{{ $shortWeekDay }}_{{ $weekDay }}">{{ $weekDay }}</label>
                                                <input type="checkbox"
                                                    id="chkCopyDay_{{ $shortWeekDay }}_{{ $weekDay }}"
                                                    class="form-check-input float-none copy-check-input ms-0"
                                                    value="{{ $weekDayKey }}">
                                            </div>
                                        @endif
                                    @endforeach
                                    <button type="button" data-copy-day="{{ $day }}"
                                        class="btn btn-primary copy-btn w-100">{{ __('messages.schedule.copy') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endforeach
</div>
