@php($scheduleDurationTime = App\Models\UserSchedule::SCHEDULE_DURATION_TIME)
@php($scheduleSlotTime = App\Models\UserSchedule::SCHEDULE_TIME_SLOT_ARR)
@php($eventGapSlotTime = App\Models\UserSchedule::EVENT_GAP_SLOT_TIME_ARR)
@php($weekDays = App\Models\UserSchedule::WEEKDAY_FULL_NAME)
<div class="tab-content" id="myTabContent">
    <div class="tab-pane fade" id="editEvent" role="tabpanel">
        {{ Form::open(['route' => ['events.update', $event->id], 'method' => 'patch', 'id' => 'eventEditForm']) }}
        <div class="card-body p-12">
            <div class="row gx-10 mb-5">
                <div class="col-sm-6">
                    <div class="mb-5">
                        {{ Form::label('name', __('messages.event.event_name') . ':', ['class' => 'form-label required']) }}
                        {{ Form::text('name', !empty($event->name) ? $event->name : null, ['class' => 'form-control ', 'placeholder' => __('messages.event.event_name'), 'required']) }}
                    </div>
                </div>
                <div class="col-sm-6">
                    {{ Form::label('event_location', __('messages.event.location') . ':', ['class' => 'form-label required']) }}
                    <div class="input-group mb-5">
                        <select name="event_location" class="form-select fw-bold event-location" required>
                            @foreach ($locationArr as $key => $value)
                                <option value="{{ $key }}" class="update-location"
                                    {{ $event->event_location == $key ? 'selected' : '' }}>{{ $value }}
                                </option>
                            @endforeach
                        </select>
                        {{ Form::hidden('location_meta', null, ['id' => 'locationAddData']) }}
                    </div>
                </div>
                <div class="col-sm-8">
                    {{ Form::label('event_link', __('messages.event.event_landing_page') . ':', ['class' => 'form-label required']) }}
                    <div class="input-group mb-5">
                        <span class="input-group-text" id="basic-addon3">{{ getEventLandingLink() }}</span>
                        {{ Form::text('event_link', !empty($event) ? $event->event_link : null, ['class' => 'form-control', 'id' => 'eventLinkId', 'placeholder' => __('messages.event.event_landing_page'), 'required']) }}
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="mb-5">
                        {{ Form::label('event_color', __('messages.event.event_color') . ':', ['class' => 'form-label required']) }}
                        <div class="color-wrapper-edit"></div>
                        {{ Form::hidden('event_color', null, ['id' => 'editEventColor', 'class' => 'form-control']) }}
                        <span id="colorError" class="text-danger"></span>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="mb-5">
                        {{ Form::label('event_type', __('messages.event.event_type') . ':', ['class' => 'form-label required']) }}
                        {{ Form::select('event_type', \App\Models\Event::EVENT_TYPE, !empty($event) ? $event->event_type : null, ['class' => 'form-select form-select-solid payment-type', 'placeholder' => __('messages.placeholder.select_event_type'), 'required', 'id' => 'paymentTypeId']) }}
                    </div>
                </div>
                <div class="col-sm-6 d-none" id="payableAmount">
                    <div class="mb-5">
                        {{ Form::label('payable_amount', __('messages.event.payable_amount') . ':', ['class' => 'form-label required']) }}
                        <div class="input-group mb-5">
                            <span class="input-group-text" id="basic-addon3">{{ getCurrencyIcon() }}</span>
                            {{ Form::text('payable_amount', !empty($event) ? $event->payable_amount : null, ['class' => 'form-control', 'placeholder' => __('messages.cash_payment.payable_amount'), 'required', 'onkeyup' => 'if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,"")', 'id' => 'payableAmountId', 'disabled' => true]) }}
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 mb-5">
                    {{ Form::label('description', __('messages.event.description') . ':', ['class' => 'form-label']) }}
                    {{ Form::textarea('description', !empty($event) ? $event->description : null, ['class' => 'form-control', 'rows' => 5, 'placeholder' => __('messages.event.description')]) }}
                </div>
                <div class="d-flex">
                    <button type="submit" class="btn btn-primary"
                        id="btnSave">{{ __('messages.common.save') }}</button>&nbsp;&nbsp;&nbsp;
                    <a href="{{ route('events.index') }}" type="reset"
                        class="btn btn-secondary">{{ __('messages.common.discard') }}</a>
                </div>
            </div>
        </div>
        {{ Form::close() }}
    </div>
    <div class="tab-pane fade active show" id="addEventSchedule" role="tabpanel">
        {{ Form::open(['id' => 'addEventScheduleForm']) }}
        <div class="card-body maincard-section p-12">
            <div class="gx-10 mb-5">
                <div class="row">
                    <div class="col-12">
                        <label class="form-label mb-3">{{ __('messages.event.date_range') . ':' }}</label>
                        <span data-bs-toggle="tooltip" data-placement="top"
                            data-bs-original-title="{{ __('messages.tooltip.set_range') }}">
                            <i class="fa fa-question-circle ms-1 fs-7"></i>
                        </span>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-check">
                            <label class="form-check-label">
                                <div class="d-flex">
                                    <input class="form-check-input me-3 mt-3" type="radio" name="date_range"
                                        value="1" {{ $event->date_range == 1 ? 'checked' : '' }}>
                                    <div>
                                        {{ Form::number('schedule_days', !empty($event->schedule_days) ? $event->schedule_days : null, ['class' => 'form-control ', 'id' => 'scheduleDayId', 'min' => 1, 'placeholder' => __('messages.event.date_range')]) }}
                                    </div>
                                    <span class="ms-2 mt-3 text-nowrap">{{ __('messages.common.next_days') }}</span>
                                </div>
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="mb-5">
                            <div class="form-check">
                                <label class="form-check-label ms-0">
                                    <div class="d-flex">
                                        <input class="form-check-input within-date-range me-3 mt-3" type="radio"
                                            name="date_range" value="0"
                                            {{ $event->date_range == 0 ? 'checked' : '' }}>
                                        <span
                                            class="text-nowrap mt-3 me-3">{{ __('messages.event.within_a_date_range') }}</span>
                                        <div>
                                            {{ Form::text('within_date_range', !empty($event->schedule_from) && !empty($event->schedule_to) ? $event->schedule_from . '-' . $event->schedule_to : null, ['class' => 'form-control d-none ', 'id' => 'withinDateRangeId', 'disabled' => true]) }}
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        {{ Form::hidden('event_id', $event->id) }}
                        <div class="mb-5">
                            {{ Form::label('slot_time', __('messages.event.slot_time') . ':', ['class' => 'form-label required ']) }}
                            <span data-bs-toggle="tooltip" data-placement="top"
                                data-bs-original-title="{{ __('messages.tooltip.set_frequency') }}">
                                <i class="fas fa-question-circle ml-1 mt-1 general-question-mark"></i></span>

                            {{ Form::select('slot_time', $scheduleSlotTime, !empty($event->slot_time) ? $event->slot_time : null, ['class' => 'form-select available-select', 'id' => 'slotTimeId']) }}
                        </div>
                    </div>
                    <div class="col-sm-6 mb-5 d-flex mt-4">
                        <div class="form-check mb-2 mt-4">
                            <label class="form-label mb-3 mt-3">
                                <input class="form-check-input after-time" type="checkbox"><span
                                    class="ms-3">{{ __('messages.event.gap_between_slots') . ':' }}</span>
                            </label>
                        </div>
                        <div class="col-sm-6 ms-3 mt-4">
                            {{ Form::select('gap_slot', $eventGapSlotTime, !empty($event->gap_slot) ? $event->gap_slot : null, ['class' => 'form-select available-select', 'id' => 'afterEventTimeId', 'disabled' => true]) }}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-6 mb-2 mt-2">
                        <span
                            class="form-label ">{{ __('messages.event.how_do_you_want_to_offer_your_availability_for') }}?</span>
                        <span data-bs-toggle="tooltip" data-placement="top"
                            data-bs-original-title="{{ __('messages.tooltip.select_one_schedule') }}">
                            <i class="fas fa-question-circle ml-1 mt-1 general-question-mark"></i></span>
                        <ul class="nav nav-pills mb-5 mt-3" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button
                                    class="nav-link button-tab py-4 mt-3 fs-5 {{ (isset($checkSelectedTab) && $checkSelectedTab == 0) || $checkSelectedTab == null ? 'active' : '' }}"
                                    id="pills-existing-tab" data-id="{{ \App\Models\UserSchedule::EXISTING_SCHEDULE }}"
                                    data-bs-toggle="pill" data-bs-target="#existingSchedule" type="button"
                                    role="tab" aria-controls="pills-home"
                                    aria-selected="true">{{ __('messages.event.use_an_existing_schedule') }}
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button
                                    class="nav-link button-tab py-4 mt-3 fs-5 {{ isset($checkSelectedTab) && $checkSelectedTab == 1 ? 'active' : '' }}"
                                    id="pills-new-tab" data-id="{{ \App\Models\UserSchedule::CUSTOM_SCHEDULE }}"
                                    data-bs-toggle="pill" data-bs-target="#AddSchedule" type="button"
                                    role="tab" aria-controls="pills-profile"
                                    aria-selected="false">{{ __('messages.event.set_custom_hours') }}
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="tab-content mt-2" id="pills-tabContent">
                    <div class="tab-pane fade {{ (isset($checkSelectedTab) && $checkSelectedTab == 0) || $checkSelectedTab == null ? 'show active' : '' }}"
                        id="existingSchedule" role="tabpanel" aria-labelledby="pills-home-tab">
                        <div class="col-sm-6 mb-5">
                            {{ Form::label('schedule_name', __('messages.schedule.which_schedule_do_you_want_to_use'), ['class' => 'form-label ']) }}
                            {{ Form::select('schedule_name', $scheduleNameArr, isset($event->schedule_id) ? $event->schedule_id : null, ['class' => 'form-select change-schedule', 'id' => 'eventScheduleId']) }}
                        </div>
                        <div class="col-12 mt-10 mb-10">
                            <i class="fas fa-globe-asia text-black me-2 fs-4"></i><span
                                class="fs-5">{{ !empty(getLogInUser()->timezone) ? \App\Models\User::TIME_ZONE_ARRAY[getLogInUser()->timezone] : \App\Models\User::TIME_ZONE_ARRAY[160] }}</span>
                        </div>
                        <div class="existing-schedule">
                            @include('events.existing_schedule')
                        </div>
                    </div>
                    <div class="tab-pane fade {{ isset($checkSelectedTab) && $checkSelectedTab == 1 ? 'show active' : '' }}"
                        id="AddSchedule" role="tabpanel" aria-labelledby="pills-existing-tab">
                        <div class="row">
                            <div class="col-sm-6">
                                {{ Form::hidden('check_tab', null, ['id' => 'checkTabId']) }}
                                <div class="mb-5">
                                    {{ Form::label('time_zone', __('messages.schedule.time_zone') . ':', ['class' => 'form-label  required']) }}
                                    {{ Form::select('timezone', \App\Models\User::TIME_ZONE_ARRAY, !(getLogInUser()->timezone == null) ? getLogInUser()->timezone : getTimeZone(), ['class' => 'form-select available-select', 'id' => 'eventTimeZoneId', 'placeholder' => __('messages.placeholder.select_time_zone'), 'required']) }}
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-5 d-flex justify-content-end">
                                    <a href="javascript:void(0)"
                                        class="fs-4 mt-3 text-decoration-none add-schedule-name">{{ __('messages.event.save_as_new_schedule') }}</a>
                                </div>
                            </div>
                        </div>
                        @foreach (App\Models\UserSchedule::WEEKDAY as $day => $shortWeekDay)
                            @php($isValid = isset($customScheduleWeekDays) && $customScheduleWeekDays->where('day_of_week', $day)->count() != 0)
                            @php($clinicScheduleDay = $customScheduleWeekDays->where('day_of_week', $day)->first())
                            <div class="">
                                <div class="weekly-content" data-day="{{ $day }}">
                                    <div class="d-flex w-100 align-items-center position-relative">
                                        <div
                                            class="d-flex flex-md-row flex-column w-100 weekly-row align-items-center">
                                            <div class="form-check mb-0 checkbox-content d-flex align-items-center">
                                                <input id="chkShortWeekDay_{{ $shortWeekDay }}"
                                                    class="form-check-input" type="checkbox"
                                                    value="{{ $day }}" name="checked_week_days[]"
                                                    @if (isset($customScheduleWeekDays)) @if ($isValid)
                                                       checked="checked"
                                                       @else
                                                       disabled @endif
                                            @elseif(!$loop->last && $clinicScheduleDay) checked="checked" @else
                                                disabled @endif>
                                            <label class="form-check-label ms-3"
                                                for="chkShortWeekDay_{{ $shortWeekDay }}">
                                                <span
                                                    class="fs-5 fw-bold d-md-block d-none">{{ strtoupper(__('messages.common.' . strtolower($shortWeekDay))) }}</span>
                                            </label>
                                        </div>
                                        @if (isset($customScheduleWeekDays))
                                            @if (!$isValid)
                                                <div class="unavailable-time">
                                                    {{ __('messages.schedule.unavailable') }}</div>
                                            @endif
                                        @elseif($loop->last || !$clinicScheduleDay)
                                            <div class="unavailable-time">
                                                {{ __('messages.schedule.unavailable') }}</div>
                                        @endif
                                        <div class="session-times">
                                            @if ($clinicScheduleDay)
                                                @if (isset($customScheduleWeekDays) && $customScheduleWeekDays->count())
                                                    @foreach ($customScheduleWeekDays->where('day_of_week', $day) as $weekDaySlot)
                                                        @include('events.slot', [
                                                            'timeArr' => getConstTimeArr(),
                                                            'day' => $day,
                                                            'weekDaySlot' => $weekDaySlot,
                                                        ])
                                                    @endforeach
                                                @else
                                                    @if (!$loop->last)
                                                        @if (!isset($customScheduleWeekDays) || $isValid)
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
                                            <a href="javascript:void(0)"
                                                class="add-session-time btn px-2 text-gray-600 fs-2"
                                                data-bs-toggle="tooltip" title="{{ __('messages.common.add') }}">
                                                <i class="fa-solid fa-plus"></i>
                                            </a>
                                            <div class="dropdown d-flex align-items-center">
                                                <button
                                                    class="btn dropdown-toggle copy-days-btn ps-2 pe-0 hide-arrow"
                                                    type="button" id="dropdownMenuButton{{ $day }}"
                                                    data-bs-toggle="dropdown" aria-expanded="false"
                                                    data-bs-auto-close="outside">
                                                    <i class="fa-solid fa-copy text-gray-600 fs-2"></i>
                                                </button>
                                                <div class="dropdown-menu copy-menu py-0 rounded-10 min-width-220"
                                                    aria-labelledby="dropdownMenuButton{{ $day }}">
                                                    <div class="p-5 menu-content">
                                                        @foreach ($weekDays as $weekDayKey => $weekDay)
                                                            @if ($day != $weekDayKey)
                                                                <div
                                                                    class="mb-5 form-check ps-0 d-flex align-items-center justify-content-between copy-label">
                                                                    <label class="form-check-label text-gray-900"
                                                                        for="chkCopyDay_{{ $shortWeekDay }}_{{ $weekDay }}">{{ $weekDay }}</label>
                                                                    <input type="checkbox"
                                                                        id="chkCopyDay_{{ $shortWeekDay }}_{{ $weekDay }}"
                                                                        class="form-check-input copy-check-input float-none ms-0"
                                                                        value="{{ $weekDayKey }}">
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                        <button type="button"
                                                            data-copy-day="{{ $day }}"
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
            </div>
            <div class="d-flex mt-10">
                <button type="button" class="btn btn-primary"
                    id="eventScheduleBtnSave">{{ __('messages.common.save') }}</button>&nbsp;&nbsp;&nbsp;
                <a href="{{ route('events.index') }}" type="reset"
                    class="btn btn-secondary">{{ __('messages.common.discard') }}</a>
            </div>
        </div>
    </div>
    {{ Form::close() }}
</div>
</div>
