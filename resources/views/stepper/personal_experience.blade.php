<div class="w-100">
    <div class="py-5">
        <div class="">
            <p class="mb-5 fw-bold fs-3 required">{{ __('messages.web.personal_your_experience') }}</p>
            <p class="fw-light fs-5">{{ __('messages.web.tell_us_about_your_role_at_work_this_will_help') }}{{ __('messages.web.provide_a_tailored_support_experience') }}.
            </p>
        </div>
        <input type="hidden" name="step" value="3" id="stepId">
        <p class="mb-3 fw-bold fs-5">{{ __('messages.web.what_is_your_day_to_day_role_at_work') }}?</p>
        @foreach($personalExperiences as $key => $personalExperience)
            <div class="form-check  form-check-sm mb-3">
                <label class="form-check-label fs-5">
                    <input class="form-check-input" type="radio" name="personal_experience_id"
                           value="{{ $key }}"
                            {{ ($key == getLogInUser()->personal_experience_id) ? 'checked' : '' }}>
                    {{ $personalExperience }}
                </label>
            </div>
        @endforeach
    </div>
</div>
