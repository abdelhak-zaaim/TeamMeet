<div class="row gx-10 mb-5">
    <div class="col-lg-9">
        <div class="mb-5">
            {{ Form::label('main_title', __('messages.main_reason.main_title').':', ['class' => 'form-label required ']) }}
            {{ Form::text('main_title', $mainReasons['main_title'], ['class' => 'form-control','required', 'placeholder' => __('messages.service.main_title'), 'maxLength' => 27]) }}
        </div>
    </div>
    <div class="col-lg-3 mb-7">
        <div class="mb-3" io-image-input="true">
            <label class="form-label"><span class="required">{{__('messages.main_reason.image')}}:</span>
                <span data-bs-toggle="tooltip"
                      data-placement="top"
                      data-bs-original-title="{{__('messages.tooltip.best_resolution')}} 700x554">
        <i class="fas fa-question-circle ml-1 mt-1 general-question-mark"></i>
</span>

            </label>
            <div class="d-block">
                <div class="image-picker">
                    <div class="image previewImage" id="bgImage"
                         style="background-image:url({{ !empty($mainReasons['image']) ? asset($mainReasons['image']) : asset('web/media/avatars/male.png') }})">
                    </div>
                    <span class="picker-edit rounded-circle text-gray-500 fs-small" title="{{__('messages.placeholder.change_image')}}">
                    <label>
                        <i class="fa-solid fa-pen" id="profileImageIcon"></i>
                         <input type="file" name="image" class="image-upload d-none"  accept=".png, .jpg, .jpeg" id="imageMainReason">
                    </label>
                </span>
                </div>
            </div>
        </div>
</div>
<div class="col-lg-12">
    <div class="col-lg-12">
        <div class="mb-5">
            {{ Form::label('title_1', __('messages.main_reason.title_1').':', ['class' => 'form-label required ']) }}
            {{ Form::text('title_1', $mainReasons['title_1'], ['class' => 'form-control', 'placeholder' => __('messages.main_reason.title_1'), 'required', 'maxLength' => 45]) }}
        </div>
    </div>
    <div class="col-lg-12">
        <div class="mb-5">
            {{ Form::label('description_1', __('messages.main_reason.description_1').':', ['class' => 'form-label required ']) }}
            {{ Form::text('description_1', $mainReasons['description_1'], ['class' => 'form-control', 'placeholder' => __('messages.main_reason.description_1'), 'required', 'maxLength' => 122]) }}
        </div>
    </div>
</div>
<div class="col-lg-12">
    <div class="col-lg-12">
        <div class="mb-5">
            {{ Form::label('title_2', __('messages.main_reason.title_2').':', ['class' => 'form-label required ']) }}
            {{ Form::text('title_2', $mainReasons['title_2'], ['class' => 'form-control', 'placeholder' => __('messages.main_reason.title_2'), 'required', 'maxLength' => 28]) }}
        </div>
    </div>
    <div class="col-lg-12">
        <div class="mb-5">
            {{ Form::label('description_2', __('messages.main_reason.description_2').':', ['class' => 'form-label required ']) }}
            {{ Form::text('description_2', $mainReasons['description_2'], ['class' => 'form-control', 'placeholder' => __('messages.main_reason.description_2'), 'required', 'maxLength' => 122]) }}
        </div>
    </div>
</div>
<div class="col-lg-12">
    <div class="col-lg-12">
        <div class="mb-5">
            {{ Form::label('title_3', __('messages.main_reason.title_3').':', ['class' => 'form-label required ']) }}
            {{ Form::text('title_3', $mainReasons['title_3'], ['class' => 'form-control', 'placeholder' => __('messages.main_reason.title_3'), 'required', 'maxLength' => 20]) }}
        </div>
    </div>
    <div class="col-lg-12">
        <div class="mb-5">
            {{ Form::label('description_3', __('messages.main_reason.description_3').':', ['class' => 'form-label required ']) }}
            {{ Form::text('description_3', $mainReasons['description_3'], ['class' => 'form-control', 'placeholder' => __('messages.main_reason.description_3'), 'required', 'maxLength' => 122]) }}
        </div>
    </div>
</div>
    <div class="d-flex">
        {{ Form::submit(__('messages.common.save'),['class' => 'btn btn-primary me-2','id'=>'mainReasonSaveBtn']) }}
    </div>
</div>

