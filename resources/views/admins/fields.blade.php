<div class="row gx-10 mb-5">
    <div class="col-lg-6">
        <div class="mb-5">
            {{ Form::label('first_name', __('messages.admin.first_name').':', ['class' => 'form-label required ']) }}
            {{ Form::text('first_name', isset($admin) ? $admin->first_name : null, ['class' => 'form-control', 'placeholder' =>  __('messages.user.first_name'), 'required']) }}
        </div>
    </div>
    <div class="col-lg-6">
        <div class="mb-5">
            {{ Form::label('last_name', __('messages.admin.last_name').':', ['class' => 'form-label required ']) }}
            {{ Form::text('last_name', isset($admin) ? $admin->last_name : null, ['class' => 'form-control', 'placeholder' => __('messages.user.last_name'), 'required']) }}
        </div>
    </div>
    <div class="col-lg-6">
        <div class="mb-5">
            {{ Form::label('email', __('messages.admin.email').':', ['class' => 'form-label required']) }}
            {{ Form::email('email', isset($admin) ? $admin->email : null, ['class' => 'form-control', 'placeholder' => __('messages.user.email'), 'required']) }}
        </div>
    </div>
    <div class="col-lg-6">
        {{ Form::label('phone_number', __('messages.admin.contact_number').':', ['class' => 'form-label required']) }}
        {{ Form::tel('phone_number', isset($admin->phone_number) ? '+'.$admin->region_code.$admin->phone_number : null,['class' => 'form-control','placeholder' =>__('messages.user.contact_number'),'onkeyup' => 'if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,"")','id'=>'phoneNumber','required']) }}
        {{ Form::hidden('region_code',!empty($admin->region_code) ? $admin->region_code : null,['id'=>'prefix_code']) }}
        <span id="valid-msg"
              class="text-success d-none fw-400 fs-small mt-2">{{__('messages.placeholder.valid_number')}}</span>
        <span id="error-msg" class="text-danger d-none fw-400 fs-small mt-2"></span>
    </div>
    @if(!isset($admin))
        <div class="col-md-6 mb-5">
            <div class="mb-1">
                {{ Form::label('password',__('messages.admin.password').':' ,['class' => 'form-label ']) }}
                <span class="text-danger">{{isset($admin) ? null : '*' }}</span>
                <div class="position-relative">
                    <input class="form-control"
                           type="password" placeholder="{{__('messages.user.password')}}" name="password"
                           autocomplete="off">
                    <span class="position-absolute d-flex align-items-center top-0 bottom-0 end-0 me-4 input-icon input-password-hide cursor-pointer text-gray-600 change-type">
                                <i class="fas fa-eye-slash"></i>
                            </span>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-5">
            <div class="mb-1">
                {{ Form::label('confirmPassword',__('messages.admin.confirm_password').':' ,['class' => 'form-label ']) }}
                <span class="text-danger">{{isset($admin) ? null : '*' }}</span>
                <div class="position-relative">
                    <input class="form-control" type="password" placeholder="{{__('messages.user.confirm_password')}}"
                           name="password_confirmation"
                           autocomplete="off">
                    <span class="position-absolute d-flex align-items-center top-0 bottom-0 end-0 me-4 input-icon input-password-hide cursor-pointer text-gray-600 change-type">
                                <i class="fas fa-eye-slash"></i>
                            </span>
                </div>
            </div>
        </div>
    @endif
    <div class="col-lg-6 mb-3" io-image-input="true">
        <label for="exampleInputImage" class="form-label">{{ __('messages.common.profile').(':') }}</label>
        <div class="d-block">
            <div class="image-picker">
                <div class="image previewImage" id="exampleInputImage"
                     style="background-image: url('{{ !empty($admin->profile_image) ? $admin->profile_image : asset('web/media/avatars/male.png') }}')">
                </div>
                <span class="picker-edit rounded-circle text-gray-500 fs-small"
                      title="{{__('messages.placeholder.change_profile')}}">
                    <label>
                        <i class="fa-solid fa-pen" id="profileImageIcon"></i>
                            <input type="file" id="profile_image" name="profile" class="image-upload d-none"
                                   accept="image/*"/>
                    </label>
                </span>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        {{ Form::label('gender', __('messages.user.gender').':', ['class' => 'form-label']) }}
        <div class="mb-5">
            <span class="is-valid">
                <input class="form-check-input" type="radio" name="gender" value="1" checked
                        {{ !empty($admin) && $admin->gender === 1 ? 'checked' : '' }} >
                <label class="form-label">{{ __('messages.user.male') }}</label>&nbsp;&nbsp;
                <input class="form-check-input" type="radio" name="gender" value="2"
                        {{ !empty($admin) && $admin->gender === 2 ? 'checked' : '' }} >
                <label class="form-label">{{ __('messages.user.female') }}</label>
            </span>
        </div>
    </div>
    <div class="d-flex">
        {{ Form::submit(__('messages.common.save'),['class' => 'btn btn-primary me-3','id'=>'createUserSaveBtn']) }}
        <a href="{{ route('admins.index') }}" type="reset"
           class="btn btn-secondary">{{__('messages.common.discard')}}</a>
    </div>
</div>
