<div class="row gx-10 mb-5">
    <div class="col-lg-12">
        <div class="mb-5">
            {{ Form::label('main_title', __('messages.service.main_title').':', ['class' => 'form-label required']) }}
            {{ Form::text('main_title', $services['main_title'], ['class' => 'form-control main-title','placeholder' =>  __('messages.service.main_title')]) }}
        </div>
    </div>
    <div class="col-lg-3 mb-7">
        <div class="mb-3" io-image-input="true">
        <label class="form-label"><span class="required">{{ __('messages.service.service_image_1') }}:</span>
            <span data-bs-toggle="tooltip"
                  data-placement="top"
                  data-bs-original-title="{{__('messages.tooltip.best_resolution')}} 75x75">
        <i class="fas fa-question-circle ml-1 mt-1 general-question-mark"></i>
</span>
        </label>
        <div class="d-block">
            <div class="image-picker">
                <div class="image previewImage" id="bgImage"
                    style="background-image: url({{ !empty($services['service_image_1']) ? asset($services['service_image_1']) : asset('web/media/avatars/male.png') }})">
                </div>
                <span class="picker-edit rounded-circle text-gray-500 fs-small" title="{{__('messages.placeholder.change_image')}}">
                    <label>
                        <i class="fa-solid fa-pen" id="profileImageIcon"></i>
                          <input type="file" name="service_image_1" class="image-upload d-none service_image"  accept=".png, .jpg, .jpeg, .svg" loading="lazy">
                    </label>
                </span>
            </div>
        </div>
    </div>
    </div>

    <div class="col-lg-9">
        <div class="col-lg-12">
            <div class="mb-5">
                {{ Form::label('service_title_1', __('messages.service.service_title_1').':', ['class' => 'form-label required']) }}
                {{ Form::text('service_title_1', $services['service_title_1'], ['class' => 'form-control service-title-1', 'placeholder' => __('messages.service.service_title_1'), 'required', 'maxLength' => 20]) }}
            </div>
        </div>
        <div class="col-lg-12">
            <div class="mb-5">
                {{ Form::label('service_description_1', __('messages.service.service_description_1').':', ['class' => 'form-label required']) }}
                {{ Form::text('service_description_1', $services['service_description_1'], ['class' => 'form-control service-description-1', 'placeholder' => __('messages.service.service_description_1'), 'required', 'maxLength' => 90]) }}
            </div>
        </div>
    </div>

    <div class="col-lg-3 mb-7">
        <div class="mb-3" io-image-input="true">
    <label class="form-label"><span class="required">{{__('messages.service.service_image_2')}}:</span>
        <span data-bs-toggle="tooltip"
              data-placement="top"
              data-bs-original-title="{{__('messages.tooltip.best_resolution')}} 75x75">
        <i class="fas fa-question-circle ml-1 mt-1 general-question-mark"></i>
</span>
    </label>
    <div class="d-block">
        <div class="image-picker">
            <div class="image previewImage" id="bgImage"
                 style="background-image: url({{ !empty($services['service_image_2']) ? asset($services['service_image_2']) : asset('web/media/avatars/male.png') }})">
            </div>
            <span class="picker-edit rounded-circle text-gray-500 fs-small" title="{{__('messages.placeholder.change_image')}}">
                    <label>
                        <i class="fa-solid fa-pen" id="profileImageIcon"></i>
                         <input type="file" name="service_image_2" class="image-upload d-none service_image"  accept=".png, .jpg, .jpeg">
                    </label>
                </span>
        </div>
    </div>
</div>
    </div>
    <div class="col-lg-9">
        <div class="col-lg-12">
            <div class="mb-5">
                {{ Form::label('service_title_2', __('messages.service.service_title_2').':', ['class' => 'form-label required']) }}
                {{ Form::text('service_title_2', $services['service_title_2'], ['class' => 'form-control service-title-2', 'placeholder' => __('messages.service.service_title_2'), 'required', 'maxLength' => 20]) }}
            </div>
        </div>
        <div class="col-lg-12">
            <div class="mb-5">
                {{ Form::label('service_description_2', __('messages.service.service_description_2').':', ['class' => 'form-label required']) }}
                {{ Form::text('service_description_2', $services['service_description_2'], ['class' => 'form-control service-description-2', 'placeholder' => __('messages.service.service_description_2'), 'required', 'maxLength' => 90]) }}
            </div>
        </div>
    </div>

    <div class="col-lg-3 mb-7">
        <div class="mb-3" io-image-input="true">
    <label class="form-label"><span class="required">{{__('messages.service.service_image_3')}}:</span>
        <span data-bs-toggle="tooltip"
              data-placement="top"
              data-bs-original-title="{{__('messages.tooltip.best_resolution')}} 75x75">
        <i class="fas fa-question-circle ml-1 mt-1 general-question-mark"></i>
</span></label>
    <div class="d-block">
        <div class="image-picker">
            <div class="image previewImage" id="bgImage"
                 style="background-image: url({{ !empty($services['service_image_3']) ? asset($services['service_image_3']) : asset('web/media/avatars/male.png') }})">
            </div>
            <span class="picker-edit rounded-circle text-gray-500 fs-small" title="{{__('messages.placeholder.change_image')}}">
                    <label>
                        <i class="fa-solid fa-pen" id="profileImageIcon"></i>
                         <input type="file" name="service_image_3" class="image-upload d-none service_image"  accept=".png, .jpg, .jpeg">
                    </label>
                </span>
        </div>
    </div>
</div>
    </div>
    <div class="col-lg-9">
        <div class="col-lg-12">
            <div class="mb-5">
                {{ Form::label('service_title_3', __('messages.service.service_title_3').':', ['class' => 'form-label required']) }}
                {{ Form::text('service_title_3', $services['service_title_3'], ['class' => 'form-control service-title-3', 'placeholder' =>  __('messages.service.service_title_3'), 'required', 'maxLength' => 20]) }}
            </div>
        </div>
        <div class="col-lg-12">
            <div class="mb-5">
                {{ Form::label('service_description_3', __('messages.service.service_description_3').':', ['class' => 'form-label required']) }}
                {{ Form::text('service_description_3', $services['service_description_3'], ['class' => 'form-control service-description-3', 'placeholder' =>__('messages.service.service_description_3'), 'required', 'maxLength' => 90]) }}
            </div>
        </div>
    </div>
    <div class="d-flex">
        {{ Form::submit(__('messages.common.save'),['class' => 'btn btn-primary me-2','id'=>'servicesSaveBtn']) }}
    </div>
</div>

