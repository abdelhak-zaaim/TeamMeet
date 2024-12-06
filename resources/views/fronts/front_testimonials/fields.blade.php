<div class="row gx-10 mb-5">
    <div class="col-lg-6">
        <div class="mb-5">
            {{ Form::label('name', __('messages.front_testimonial.name').':', ['class' => 'form-label required']) }}
            {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => __('messages.front_testimonial.name'), 'required','maxlength' => '100']) }}
        </div>
    </div>
    <div class="col-lg-6">
        <div class="mb-5">
            {{ Form::label('designation', __('messages.front_testimonial.designation').':', ['class' => 'form-label required']) }}
            {{ Form::text('designation', null, ['class' => 'form-control', 'placeholder' => __('messages.front_testimonial.designation'), 'required','maxlength' => '100']) }}
        </div>
    </div>
    <div class="col-lg-6">
        <div class="mb-5">
            {{ Form::label('short_description', __('messages.front_testimonial.short_description').':', ['class' => 'form-label required']) }}
            {{ Form::textarea('short_description', null, ['class' => 'form-control', 'placeholder' =>  __('messages.front_testimonial.short_description'), 'required', 'id' => 'shortDescription', 'rows'=> 5, 'maxlength' => '230']) }}
        </div>
    </div>
    <div class="col-lg-6 mb-7">
        <div class="mb-3" io-image-input="true">
            <label class="form-label"><span class="required">{{ __('messages.front_testimonial.profile')}}:</span>
                <span data-bs-toggle="tooltip"
                      data-placement="top"
                      data-bs-original-title="{{__('messages.tooltip.best_resolution')}} 50x50">
        <i class="fas fa-question-circle ml-1 mt-1 general-question-mark"></i>
</span>
            
            </label>
            <div class="d-block">
                <div class="image-picker">
                    <div class="image previewImage" id="bgImage"
                         style="background-image: url('{{ !empty($cmsData['front_image']) ? asset($cmsData['front_image']) : asset('web/media/avatars/male.png') }}')">
                    </div>
                    <span class="picker-edit rounded-circle text-gray-500 fs-small" title="{{__('messages.placeholder.change_profile')}}">
                    <label>
                        <i class="fa-solid fa-pen" id="profileImageIcon"></i>
                         <input type="file" name="profile" class="image-upload d-none"  accept=".png, .jpg, .jpeg" id="profileImage">
                          <input type="hidden" name="avatar_remove">
                    </label>
                </span>
                </div>
            </div>
        </div>
</div>
    <div class="d-flex">
        {{ Form::submit(__('messages.common.save'),['class' => 'btn btn-primary me-3','id'=>'frontTestimonialSaveBtn']) }}
        <a href="{{ route('front-testimonials.index') }}" type="reset"
           class="btn btn-secondary">{{__('messages.common.discard')}}</a>
    </div>
</div>
