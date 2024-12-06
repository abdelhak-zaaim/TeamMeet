<div class="row">
    {{-- Subscription Plan section starts --}}
    <div class="col-md-4 mb-5">
        <div class="form-group">
            {{ Form::label('name', __('messages.subscription_plan.name').(':'), ['class' => 'form-label required']) }}
            {{ Form::text('name', null , ['class' => 'form-control','required','placeholder' => __('messages.subscription_plan.name'),'id'=>'name']) }}
        </div>
    </div>
    <div class="col-md-4 mb-5">
        <div class="form-group">
            {{ Form::label('currency', __('messages.subscription_plan.currency').(':'), ['class' => 'form-label for_trail_label required']) }}
            {{ Form::select('currency', getCurrencies(), null,['class' => 'form-control for_trail_required','id'=>'currency','placeholder'=>__('messages.placeholder.select_currency'), 'required']) }}
        </div>
    </div>
    <div class="col-md-4 mb-5">
        <div class="form-group">
            {{ Form::label('price', __('messages.subscription_plan.price').(':'), ['class' => 'form-label for_trail_label required']) }}
            {{ Form::text('price', null , ['class' => 'form-control price-input price for_trail_required','placeholder' => __('messages.subscription_plan.price'), 'id'=>'price','maxlength' => '4', 'required']) }}
        </div>
    </div>
    <div class="col-md-4 mb-5">
        <div class="form-group">
            {{ Form::label('frequency', __('messages.subscription_plan.plan_type').(':'), ['class' => 'form-label for_trail_label required']) }}
            {{ Form::select('frequency', $planType, null, ['required', 'id' => 'planType','class' => 'form-select for_trail_required', 'required']) }}
        </div>
    </div>
    <div class="col-md-4 mb-5">
        <div class="form-group">
            {{ Form::label('trial_days', __('messages.subscription_plan.trail_plan').(':'), ['class' => 'form-label for_trail_label']) }}
            {{ Form::text('trial_days', null , ['class' => 'form-control price-input price for_trail_required','placeholder' =>__('messages.subscription_plan.trail_plan'), 'id'=>'trialDays','maxlength' => '3', 'onkeyup' => 'if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,"")']) }}
        </div>
    </div>
    {{-- Subscription Plan section ends --}}

    {{-- Subscription Plan Features starts here --}}
    @include('subscription_plans.plan_features')
    {{-- Subscription Plan Features ends here --}}
    <div class="separator my-5"></div>
    <div class="d-flex">
        {{ Form::submit(__('messages.common.save'), ['class' => 'btn btn-primary me-3', 'id' => 'btnSave']) }}
        <a href="{{ route('subscription-plans.index') }}"
           class="btn btn-secondary">{{ __('messages.common.cancel') }}</a>
    </div>
</div>
