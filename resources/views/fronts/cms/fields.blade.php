<div class="row gx-10 mb-5">
    <div class="col-lg-8">
        <div class="mb-5">
            {{ Form::label('title', __('messages.web.title').':', ['class' => 'form-label required']) }}
            {{ Form::text('title', $cmsData['title'], ['class' => 'form-control', 'placeholder' => __('messages.web.title'), 'id' => 'titleId','maxlength' => '41']) }}
        </div>
    </div>
    <div class="col-lg-4">
    <div class="mb-3" io-image-input="true">
        <label class="form-label"><span class="required">{{__('messages.web.image')}}:</span>
            <span data-bs-toggle="tooltip"
                  data-placement="top"
                  data-bs-original-title="{{__('messages.tooltip.best_resolution')}} 690X534">
        <i class="fas fa-question-circle ml-1 mt-1 general-question-mark"></i>
</span>
        </label>
        <div class="d-block">
            <div class="image-picker">
                <div class="image previewImage" id="bgImage"
                     style="background-image: url('{{ !empty($cmsData['front_image']) ? asset($cmsData['front_image']) : asset('web/media/avatars/male.png') }}')">
                </div>
                <span class="picker-edit rounded-circle text-gray-500 fs-small" title="{{__('messages.placeholder.change_image')}}">
                    <label>
                        <i class="fa-solid fa-pen" id="profileImageIcon"></i>
                         <input type="file" name="front_image" class="image-upload d-none"  accept=".png, .jpg, .jpeg" id="frontImage">
                    </label>
                </span>
            </div>
        </div>
    </div>
</div>
    <div class="col-lg-6">
        <div class="mb-5">
            {{ Form::label('email', __('messages.user.email').':', ['class' => 'form-label required']) }}
            {{ Form::text('email', $cmsData['email'], ['class' => 'form-control', 'placeholder' => __('messages.user.email')]) }}
        </div>
    </div>
    <div class="col-lg-6">
        <div class="mb-5">
            {{ Form::label('phone', __('messages.cms_setting.contact').':', ['class' => 'form-label required']) }}
            {{ Form::tel('phone', isset($cmsData['phone']) ? '+'.$cmsData['region_code'].$cmsData['phone'] : null,['class' => 'form-control','placeholder' => __('messages.cms_setting.contact'),'onkeyup' => 'if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,"")','id'=>'phoneNumber']) }}
            {{ Form::hidden('region_code',!empty($cmsData['region_code']) ? $cmsData['region_code'] : null,['id'=>'prefix_code']) }}
            <span id="valid-msg"
                  class="text-success d-none fw-400 fs-small mt-2">{{__('messages.placeholder.valid_number')}}</span>
            <span id="error-msg" class="text-danger d-none fw-400 fs-small mt-2"></span>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="mb-5">
            {{ Form::label('address', __('messages.setting.address').':', ['class' => 'form-label required']) }}
            {{ Form::text('address', $cmsData['address'], ['class' => 'form-control', 'placeholder' => __('messages.common.address'),'maxlength'=>'100']) }}
        </div>
    </div>
    <div class="col-lg-6">
        <div class="mb-5">
            {{ Form::label('facebook_url', __('messages.cms_setting.facebook_url').':', ['class' => 'form-label required 0']) }}
            {{ Form::text('facebook_url', $cmsData['facebook_url'], ['class' => 'form-control','id' => 'facebookUrl', 'placeholder' => __('messages.cms_setting.facebook_url'), 'required']) }}
        </div>
    </div>
    <div class="col-lg-6">
        <div class="mb-5">
            {{ Form::label('twitter_url', __('messages.cms_setting.twitter_url').':', ['class' => 'form-label required 0']) }}
            {{ Form::text('twitter_url', $cmsData['twitter_url'], ['class' => 'form-control','id' => 'twitterUrl', 'placeholder' => __('messages.cms_setting.twitter_url'), 'required']) }}
        </div>
    </div>
    <div class="col-lg-6">
        <div class="mb-5">
            {{ Form::label('instagram_url', __('messages.cms_setting.instagram_url').':', ['class' => 'form-label required 0']) }}
            {{ Form::text('instagram_url', $cmsData['instagram_url'], ['class' => 'form-control','id' => 'instagramUrl', 'placeholder' => __('messages.cms_setting.instagram_url'), 'required']) }}
        </div>
    </div>
    <div class="col-lg-12">
        <div class="mb-5">
            {{ Form::label('description', __('messages.web.description').':', ['class' => 'form-label required 0']) }}
            {{ Form::textarea('description', $cmsData['description'], ['class' => 'form-control', 'placeholder' => __('messages.about_us.description'),'id' => 'descriptionId', 'required', 'maxlength' => '74','rows'=> 5]) }}
        </div>
    </div>
    <div class="col-lg-12">
        <div class="mb-5">
            {{ Form::label('term_condition', __('messages.cms_setting.terms_conditions').':', ['class' => 'form-label required 0']) }}
            <div id="termConditionId" class="editor-height"></div>
            {{ Form::hidden('terms_conditions', null, ['id' => 'termData']) }}
        </div>
    </div>
    <div class="col-lg-12">
        <div class="mb-5">
            {{ Form::label('privacy_policy', __('messages.cms_setting.privacy_policy').':', ['class' => 'form-label required 0']) }}
            <div id="privacyPolicyId" class="editor-height"></div>
            {{ Form::hidden('privacy_policy', null, ['id' => 'privacyData']) }}
        </div>
    </div>
    <div class="d-flex">
        {{ Form::submit(__('messages.common.save'),['class' => 'btn btn-primary me-2','id'=>'cmsSaveButton']) }}
    </div>
</div>

