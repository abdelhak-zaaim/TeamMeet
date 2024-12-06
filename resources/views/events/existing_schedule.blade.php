<div class="mb-5 maincard-section">
    @foreach (App\Models\UserSchedule::WEEKDAY as $day => $shortWeekDay)
        @php($isValid = isset($existingScheduleWeekDays) && $existingScheduleWeekDays->where('day_of_week', $day)->count() != 0)
        <div class="weekly-content">
            <div class="d-flex w-100 align-items-center position-relative">
                <div class="d-flex flex-md-row flex-column w-100 weekly-row align-items-center">
                    <div class="form-check checkbox-content mb-0 d-flex align-items-center">
                        <label class="form-check-label ms-3 me-3">
                            <span
                                class="fs-5 fw-bold d-md-block d-none">{{ strtoupper(__('messages.common.' . strtolower($shortWeekDay))) }}</span>
                        </label>
                    </div>
                    @if (isset($existingScheduleWeekDays))
                        @if (!$isValid)
                            <div class="unavailable-time">{{ __('messages.schedule.unavailable') }}</div>
                        @endif
                    @elseif($loop->last)
                        <div class="unavailable-time">{{ __('messages.schedule.unavailable') }}</div>
                    @endif
                    <div class="session-times">
                        @if (isset($existingScheduleWeekDays) && $existingScheduleWeekDays->count())
                            @foreach ($existingScheduleWeekDays->where('day_of_week', $day) as $weekDaySlot)
                                <span>{{ \Carbon\Carbon::parse($weekDaySlot->from_time)->format(getUserSettingTimeFormat(getLogInUserId())) . ' - ' . \Carbon\Carbon::parse($weekDaySlot->to_time)->format(getUserSettingTimeFormat(getLogInUserId())) }}
                                    {{ $loop->last ? '' : '/' }}</span>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
