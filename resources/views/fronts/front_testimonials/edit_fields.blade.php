<div class="row gx-10 mb-5">
    <div class="col-lg-6">
        <div class="mb-5">
            {{ Form::label('name', __('messages.front_testimonial.name').':', ['class' => 'form-label required']) }}
            {{ Form::text('name', !empty($frontTestimonial) ? $frontTestimonial->name : null, ['class' => 'form-control', 'placeholder' => __('messages.front_testimonial.name'), 'required', 'maxlength' => '100']) }}
        </div>
    </div>
    <div class="col-lg-6">
        <div class="mb-5">
            {{ Form::label('designation', __('messages.front_testimonial.designation').':', ['class' => 'form-label required']) }}
            {{ Form::text('designation', !empty($frontTestimonial) ? $frontTestimonial->designation : null, ['class' => 'form-control', 'placeholder' => __('messages.front_testimonial.designation'), 'required', 'maxlength' => '100']) }}
        </div>
    </div>
    <div class="col-lg-6">
        <div class="mb-5">
            {{ Form::label('short_description', __('messages.front_testimonial.short_description').':', ['class' => 'form-label required']) }}
            {{ Form::textarea('short_description', !empty($frontTestimonial) ? $frontTestimonial->short_description : null, ['class' => 'form-control', 'placeholder' => __('messages.front_testimonial.short_description'), 'required', 'id' => 'shortDescription', 'rows'=> 5, 'maxlength' => '230']) }}
        </div>
    </div>
    <div class="col-lg-6 mb-7">
        <div class="mb-5">
            {{ Form::label('name', __('messages.front_testimonial.profile').':', ['class' => 'form-label required']) }}
            <div class="d-block">
                <div class="image-picker">
                    <div class="image previewImage" id="editLogo"
                         style="background-image:url('{{ $frontTestimonial->front_profile }}')">
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
