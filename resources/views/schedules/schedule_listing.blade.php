<div class="row">
    <div class="card">
        <div class="col-12 py-4 px-4">
            {{ Form::open(['id' => 'addScheduleTimeForm']) }}
            @livewire('schedules',['scheduleId' => defaultUserSchedule()])
            <div class="d-flex mt-10 mb-5 ms-6">
                <button type="submit" class="btn btn-primary"
                        id='scheduleSaveButton'>{{ __('messages.common.save')}}</button>&nbsp;&nbsp;&nbsp;
                <a href="{{ route('schedules.index') }}" type="reset"
                   class="btn btn-secondary">{{ __('messages.common.discard') }}</a>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
