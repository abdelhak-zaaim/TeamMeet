<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-modal="true" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3>{{ __('messages.user.change_password') }}</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>
            {{ Form::open(['id'=>'changePasswordForm']) }}
            @csrf
            @method('PUT')
            <div class="modal-body">
                <div class="alert alert-danger d-none" id="editPasswordValidationErrorsBox"></div>
                <div class="mb-5 position-relative">
                    {{ Form::label('current_password',__('messages.user.current_password').':', ['class' => 'form-label required']) }}
                    {{Form::password('current_password',['class' => 'form-control' ,'placeholder' => __('messages.user.current_password'), 'autocomplete'=> 'off'])}}
                    <span class="position-absolute d-flex align-items-center top-0 mt-7 bottom-0 end-0 me-4 input-icon input-password-hide cursor-pointer text-gray-600 change-type">
                                <i class="fas fa-eye-slash"></i>
                            </span>
                </div>
                <div class="mb-5 position-relative">
                    {{ Form::label('new_password',__('messages.user.new_password').':', ['class' => 'form-label required']) }}
                    {{Form::password('new_password',['class' => 'form-control','placeholder' => __('messages.user.new_password'), 'autocomplete'=> 'off'])}}
                    <span class="position-absolute d-flex align-items-center top-0 mt-7 bottom-0 end-0 me-4 input-icon input-password-hide cursor-pointer text-gray-600 change-type">
                                <i class="fas fa-eye-slash"></i>
                            </span>
                </div>
                <div class="position-relative">
                    {{ Form::label('confirm_password',__('messages.user.confirm_password').':', ['class' => 'form-label required']) }}
                    {{Form::password('confirm_password',['class' => 'form-control','placeholder' => __('messages.user.confirm_password'), 'autocomplete'=> 'off'])}}
                    <span class="position-absolute d-flex align-items-center top-0 mt-7 bottom-0 end-0 me-4 input-icon input-password-hide cursor-pointer text-gray-600 change-type">
                                <i class="fas fa-eye-slash"></i>
                            </span>
                </div>
            </div>
            <div class="modal-footer pt-0">
                {{ Form::button(__('messages.common.save'),['class' => 'btn btn-primary m-0','id' => 'passwordChangeBtn']) }}
                {{ Form::button(__('messages.common.discard'),['class' => 'btn btn-secondary my-0 ms-5 me-0','data-bs-dismiss' => 'modal']) }}
            </div>
            {{ Form::close()}}
        </div>
    </div>
</div>
