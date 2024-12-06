<div class="modal fade" id="createBrandModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">{{ __('messages.brand.add_front_brand')}}</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>
            {{ Form::open(['id'=>'createBrandForm','files'=>true]) }}
            <div class="modal-body">
                <div class="alert alert-danger fs-4 text-white d-flex align-items-center  d-none" role="alert" id="createBrandValidationErrorsBox">
                    <i class="fa-solid fa-face-frown me-5"></i>
                </div>
                <div class="mb-5">
                    {{ Form::label('name', __('messages.brand.logo').':', ['class' => 'form-label required']) }}
                    <div class="d-block">
                        <div class="image-picker">
                            <div class="image previewImage" id="bgImage"
                                 style="background-image:url('{{ asset('web/media/avatars/male.png') }}')">
                            </div>
                            <span class="picker-edit rounded-circle text-gray-500 fs-small" title="{{__('messages.placeholder.change_logo')}}">
                                <label>
                                    <i class="fa-solid fa-pen" id="profileImageIcon"></i>
                                     <input type="file" name="brand_logo" class="image-upload d-none"
                                            accept=".png, .jpg, .jpeg">
                                </label>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer pt-0">
                {{ Form::button(__('messages.common.save'), ['type'=>'submit','class' => 'btn btn-primary m-0','id'=>'addBrandBtn']) }}
                <button type="button" class="btn btn-secondary my-0 ms-5 me-0"
                        data-bs-dismiss="modal">{{ __('messages.common.discard') }}</button>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>

