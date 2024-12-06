<div class="row gx-10 mb-5">
    <div class="col-lg-6">
        <div class="mb-5">
            {{ Form::label('first_name', __('messages.user.first_name') . ':', ['class' => 'form-label required ']) }}
            {{ Form::text('first_name', isset($user) ? $user->first_name : null, ['class' => 'form-control', 'placeholder' => __('messages.user.first_name'), 'required']) }}
        </div>
    </div>
    <div class="col-lg-6">
        <div class="mb-5">
            {{ Form::label('last_name', __('messages.user.last_name') . ':', ['class' => 'form-label required ']) }}
            {{ Form::text('last_name', isset($user) ? $user->last_name : null, ['class' => 'form-control', 'placeholder' => __('messages.user.last_name'), 'required']) }}
        </div>
    </div>
    <div class="col-lg-6">
        <div class="mb-5">
            {{ Form::label('email', __('messages.user.email') . ':', ['class' => 'form-label required']) }}
            {{ Form::email('email', isset($user) ? $user->email : null, ['class' => 'form-control', 'placeholder' => __('messages.user.email'), 'required']) }}
        </div>
    </div>
    <div class="col-lg-6 mb-5">
        {{ Form::label('phone_number', __('messages.user.contact_number') . ':', ['class' => 'form-label required']) }}
        {{ Form::tel('phone_number', isset($user->phone_number) ? '+' . $user->region_code . $user->phone_number : null, ['class' => 'form-control', 'placeholder' => __('messages.user.contact_number'), 'onkeyup' => 'if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,"")', 'id' => 'phoneNumber', 'required']) }}
        {{ Form::hidden('region_code', !empty($user->region_code) ? $user->region_code : null, ['id' => 'prefix_code']) }}
        <span id="valid-msg"
            class="text-success d-none fw-400 fs-small mt-2">{{ __('messages.placeholder.valid_number') }}</span>
        <span id="error-msg" class="text-danger d-none fw-400 fs-small mt-2"></span>
    </div>
    @if (!isset($user))
        <div class="col-md-6 mb-5">
            <div>
                {{ Form::label('password', __('messages.user.password') . ':', ['class' => 'form-label ']) }}
                <span class="text-danger">{{ isset($user) ? null : '*' }}</span>
                <div class="position-relative">
                    <input class="form-control" type="password" placeholder="{{ __('messages.user.password') }}"
                        name="password" autocomplete="off">
                    <span
                        class="position-absolute d-flex align-items-center top-0 bottom-0 end-0 me-4 input-icon input-password-hide cursor-pointer text-gray-600 change-type">
                        <i class="fas fa-eye-slash"></i>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-5">
            <div>
                {{ Form::label('confirmPassword', __('messages.user.confirm_password') . ':', ['class' => 'form-label ']) }}
                <span class="text-danger">{{ isset($user) ? null : '*' }}</span>
                <div class="position-relative">
                    <input class="form-control" type="password"
                        placeholder="{{ __('messages.user.confirm_password') }}" name="password_confirmation"
                        autocomplete="off">
                    <span
                        class="position-absolute d-flex align-items-center top-0 bottom-0 end-0 me-4 input-icon input-password-hide cursor-pointer text-gray-600 change-type">
                        <i class="fas fa-eye-slash"></i>
                    </span>
                </div>
            </div>
        </div>
    @endif
    <div class="col-lg-6">
        <div class="mb-5">
            {{ Form::label('first_name', __('messages.user.personal_experience') . ':', ['class' => 'form-label required']) }}
            {{ Form::select('personal_experience_id', $personalExperience, isset($user) ? $user->personal_experience_id : null, ['class' => 'form-select', 'id' => 'personalExperienceId', 'placeholder' => __('messages.user.personal_experience')]) }}
        </div>
    </div>
    <div class="col-lg-6">
        <div class="mb-5">
            {{ Form::label('plan', __('messages.user.subscription_plans') . ':', ['class' => 'form-label required']) }}
            {{ Form::select('subscription_plans_id', $plan, $currentPlan ?? null, ['class' => 'form-select', 'id' => 'subscriptionPlansId', 'placeholder' => __('messages.user.subscription_plans'), isset($user) ? 'disabled' : '']) }}
        </div>
    </div>
    <div class="col-lg-6">
        {{ Form::label('gender', __('messages.user.gender') . ':', ['class' => 'form-label']) }}
        <div class="mb-5">
            <span class="is-valid">
                <input class="form-check-input" type="radio" name="gender" value="1" checked
                    {{ !empty($user) && $user->gender == 1 ? 'checked' : '' }}>
                <label class="form-label">{{ __('messages.user.male') }}</label>&nbsp;&nbsp;
                <input class="form-check-input" type="radio" name="gender" value="2"
                    {{ !empty($user) && $user->gender == 2 ? 'checked' : '' }}>
                <label class="form-label">{{ __('messages.user.female') }}</label>
            </span>
        </div>
    </div>
    <div class="mb-3" io-image-input="true">
        <label for="exampleInputImage" class="form-label">{{ __('messages.common.profile') . ':' }}</label>
        <div class="d-block">
            <div class="image-picker">
                <div class="image previewImage" id="exampleInputImage"
                    style="background-image: url('{{ !empty($user->profile_image) ? $user->profile_image : asset('web/media/avatars/male.png') }}')">
                </div>
                <span class="picker-edit rounded-circle text-gray-500 fs-small"
                    title="{{ __('messages.placeholder.change_profile') }}">
                    <label>
                        <i class="fa-solid fa-pen" id="profileImageIcon"></i>
                        <input type="file" id="profile_image" name="profile" class="image-upload d-none"
                            accept="image/*" />
                    </label>
                </span>
            </div>
        </div>
    </div>
    <div class="d-flex">
        {{ Form::submit(__('messages.common.save'), ['class' => 'btn btn-primary me-3', 'id' => 'createUserSaveBtn']) }}
        <a href="{{ route('users.index') }}" type="reset"
            class="btn btn-secondary">{{ __('messages.common.discard') }}</a>
    </div>
</div>
