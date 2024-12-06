<div class="modal fade" id="editPersonalExperienceModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">{{__('messages.personal_experience.edit_personal_experience')}}</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>
            {{ Form::open(['id'=>'editPersonalExperienceForm','method' => 'PUT']) }}
            {{ Form::hidden('id',null,['id' => 'personalExperienceID']) }}
            <div class="modal-body">
                <div class="alert alert-danger fs-4 text-white d-flex align-items-center  d-none" role="alert" id="personalExperienceValidationErrorsBox">
                    <i class="fa-solid fa-face-frown me-5"></i>
                </div>
                <div class="mb-5">
                    {{ Form::label('name', __('messages.common.name').':', ['class' => 'form-label required']) }}
                    {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => __('messages.common.name'),                                     'required','id'=>'editName']) }}
                </div>
            </div>
            <div class="modal-footer pt-0">
                {{ Form::button(__('messages.common.save'), ['type'=>'submit','class' => 'btn btn-primary m-0','id'=>'editBtnSave']) }}
                <button type="button" class="btn btn-secondary my-0 ms-5 me-0"
                        data-bs-dismiss="modal">{{ __('messages.common.discard') }}</button>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>

