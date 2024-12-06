<div class="separator my-3"></div>
    <div class="row">
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
        <h4 class="mt-2">{{ __('messages.subscription_plan.plan_features') }}</h4>
    </div>
</div>
<div class="separator my-3"></div>
<div class="row">
    <div class="col-md-6 mb-5">
        <div class="form-group">
            {{ Form::label('events', __('messages.events').(':'), ['class' => 'form-label required']) }}
            <span data-bs-toggle="tooltip"
                  data-placement="top"
                  data-bs-original-title="{{__('messages.tooltip.create_event')}}">
        <i class="fas fa-question-circle ml-1 mt-1 general-question-mark"></i></span>
                {{ Form::text('events', $subscriptionPlans->planFeature->events ?? null , [
                    'class' => 'form-control',
                    'placeholder' => __('messages.events'),
                    'onkeyup' => 'if (!/^(1|-1|[1-9]\d{0,5})?$/.test(this.value)) { if (!/^-?(1|-1)?$/.test(this.value)) { this.value = ""; } }',
                    'required'
                ]) }}
        </div>
    </div>
    <div class="col-md-6 mb-5">
        <div class="form-group">
            {{ Form::label('schedule_events', __('messages.subscription_plan.schedule_events').(':'), ['class' => 'form-label required']) }}
            <span data-bs-toggle="tooltip"
                  data-placement="top"
                  data-bs-original-title="{{__('messages.tooltip.create_schedule_event')}}">
        <i class="fas fa-question-circle ml-1 mt-1 general-question-mark"></i></span>
        {{ Form::text('schedule_events', $subscriptionPlans->planFeature->schedule_events ?? null , [
                    'class' => 'form-control',
                    'placeholder' => __('messages.subscription_plan.schedule_events'),
                    'onkeyup' => 'if (!/^(1|-1|[1-9]\d{0,5})?$/.test(this.value)) { if (!/^-?(1|-1)?$/.test(this.value)) { this.value = ""; } }',
                    'required'
                ]) }}
        </div>
    </div>
</div>
