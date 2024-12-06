<div class="w-100">
    <div class="py-5">
        <div class="">
            <p class="mb-3 fw-bold fs-3">{{ __('messages.web.set_your_availability') }}</p>
            <p class="fw-light fs-5">{{ __('messages.web.let_infycal_know_when_your_typically_available_to') }}{{ __('messages.web.accept_meetings') }}.
            </p>
        </div>
        <p class="mb-3 fw-bold fs-4 required">{{ __('messages.web.available_hours') }}</p>
        <input type="hidden" name="step" value="2" id="stepId">
        <div class="row on-board-time">
            <div class="col-lg-6 mb-4 ms-sm-0">
                {{ Form::select('from_time',getSchedulesTiming() , !empty($userSchedule->from_time) ? $userSchedule->from_time :  null,['class' => 'form-control available-select','id' => 'fromTime','placeholder' => __('messages.placeholder.select_from_time'),'required']) }}
            </div>
            <div class="col-lg-6">
                {{ Form::select('to_time', getSchedulesTiming() , !empty($userSchedule->to_time) ? $userSchedule->to_time : null,['class' => 'form-control available-select','id' => 'toTime','placeholder' => __('messages.placeholder.select_to_time'),'required']) }}
            </div>
        </div>
        <div class="mt-8">
            <div class="d-flex justify-content-between flex-sm-nowrap flex-wrap">
                <p class="mb-3 fw-bold fs-4 required">{{ __('messages.web.available_days') }}</p>
                <div>
                    <label class="form-check fw-bold me-">
                        <span class="ms-2">{{ __('messages.subscription_plan.select_all') }}</span>
                        <input class="form-check-input ms-2" type="checkbox" id="checkAllDays"/>
                    </label>
                </div>
            </div>
            <div class="available-days border">
                @foreach($dayOfWeeks as $key => $dayOfWeek)
                    <div class="form-check form-check-sm week-checkbox border-end">
                        <input class="form-check-input day-of-week ms-0" type="checkbox" name="day_of_week[]"
                               value="{{ $key }}"
                                {{ in_array($key, $selectedDayOfWeeks) ? 'checked' : '' }}>
                        <label class="form-check-label mt-xxl-2 mt-0 ms-3 ms-xxl-0 " for="flexRadioLg">
                            {{ $dayOfWeek }}
                        </label>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="d-flex justify-content-center align-items-center mt-10">
            <i class="fas fa-bullhorn d-flex fs-5"></i>
            <p class="ms-3 fw-light m-0 fs-5">{{ __('messages.web.don_worry_you_be_able_to_further_customize_your') }}
                .</p>
        </div>
    </div>
</div>
