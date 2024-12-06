<div class="modal fade" id="cancelScheduleEventModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">{{__('messages.cancel_schedule_event')}}</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>
            {{ Form::open(['id'=>'cancelScheduleEventForm']) }}
            <div class="modal-body">
                <div class="alert alert-danger fs-4 text-white d-flex align-items-center  d-none" role="alert"
                     id="cancelValidationErrorsBox">
                    <i class="fa-solid fa-face-frown me-5"></i>
                </div>
                {{ Form::hidden('schedule_event_id',null,['id' => 'scheduleEventId']) }}
                <div class="mb-5">
                    {{ Form::label('name', __('messages.schedule_event.cancel_reason').':', ['class' => 'form-label required']) }}
                    {{ Form::text('cancel_reason', null, ['class' => 'form-control','id' => 'cancelReason', 'placeholder' => __('messages.schedule_event.cancel_reason'), 'required','autocomplete' => 'off']) }}
                </div>
            </div>
            <div class="modal-footer pt-0">
                {{ Form::button(__('messages.common.save'), ['type'=>'submit','class' => 'btn btn-primary m-0','id'=>'btnSave']) }}
                <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">{{ __('messages.common.discard') }}</button>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>

