<div class="modal fade" id="editScheduleNameModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">{{ __('messages.schedule.edit_schedule') }}</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>
            {{ Form::open(['id' => 'editScheduleNameForm']) }}
            <div class="modal-body">
                <div class="alert alert-danger fs-4 text-white d-flex align-items-center  d-none" role="alert"
                     id="scheduleValidationErrorsBox">
                    <i class="fa-solid fa-face-frown me-5"></i>
                </div>
                {{ Form::hidden('schedule_id',null, ['id' => 'editScheduleId']) }}
                {{ Form::hidden('is_default',null, ['id' => 'isDefaultId']) }}
                <div class="mb-5">
                    {{ Form::label('schedule_name',__('messages.schedule.schedule_name').':' ,['class' => 'form-label required']) }}
                    {{ Form::text('schedule_name', null,['class' => 'form-control','id' => 'editScheduleNameId','placeholder' => __('messages.schedule.schedule_name')]) }}
                </div>
                <div class="mb-5">
                    {{ Form::label('status',__('messages.schedule.status').':' ,['class' => 'form-label required']) }}
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="status" value="1" id="editStatusId"
                               checked="checked"/>
                    </div>
                </div>
            </div>
            <div class="modal-footer pt-0">
                {{ Form::submit(__('messages.common.save'),['class' => 'btn btn-primary','id'=> 'editScheduleNameBtn']) }}
                {{ Form::button(__('messages.common.discard'),['class' => 'btn btn-secondary','data-bs-dismiss'=>'modal']) }}
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>

