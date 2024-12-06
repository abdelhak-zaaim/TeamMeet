<div>
    <div class="w-100">
        <div class="d-flex justify-content-center align-items-center border-bottom">
            <div class="py-5">
                <p class="mb-5 fw-bold fs-4 required">{{ __('messages.web.create_your_infycal_url') }}</p>
                <p class="fw-light mb-5 fs-6">{{ __('messages.web.choose_a_url_that_describes') }}
                    {{ __('messages.web.and_easy_to_remember_so_you_can_share_links_with') }}.
                </p>
                <div class="row mb-2">
                    <input type="hidden" name="step" value="1" id="stepId">
                    <div class="col-md-12 mb-5">
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1">{{ Request::root().'/' }}</span>
                            <input type="text" name="domain_url" class="form-control" id="domainUrlId"
                                   value="{{ getLogInUser()->domain_url ?? '' }}" required>
                        </div>
                    </div>
                    <div class="col-md-12">
                        {{ Form::label('timezone',__('messages.schedule.time_zone'),['class' => 'form-label']) }}
                        <div class="input-group">
                            {{ Form::select('timezone', \App\Models\User::TIME_ZONE_ARRAY, !empty(getLogInUser()->timezone) ? getLogInUser()->timezone : getTimeZone(),['class' => 'form-select available-select timezone', 'id' => 'customerTimeZoneId', 'placeholder' => __('messages.placeholder.select_time_zone'),'required']) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
