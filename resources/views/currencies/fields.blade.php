<div class="row gx-10 mb-5">
    <div class="fv-row mb-7 fv-plugins-icon-container">
        {{ Form::label('currency_name', 'Currency Name:', ['class' => 'required fw-bold fs-6 mb-2']) }}
        {{ Form::text('currency_name', null, ['class' => 'form-control form-control-solid mb-3 mb-lg-0', 'placeholder' =>  __('messages.currency.currency_name'), 'required']) }}
        <div class="fv-plugins-message-container invalid-feedback"></div>
    </div>
    <div class="fv-row mb-7 fv-plugins-icon-container">
        {{ Form::label('currency_icon', 'Currency Icon:', ['class' => 'required fw-bold fs-6 mb-2']) }}
        {{ Form::text('currency_icon', null, ['class' => 'form-control form-control-solid mb-3 mb-lg-0', 'placeholder' =>  __('messages.currency.currency_icon'), 'required']) }}
        <div class="fv-plugins-message-container invalid-feedback"></div>
    </div>
    <div class="fv-row mb-7 fv-plugins-icon-container">
        {{ Form::label('currency_code', 'Currency Code:', ['class' => 'required fw-bold fs-6 mb-2']) }}
        {{ Form::text('currency_code', null, ['class' => 'form-control form-control-solid mb-3 mb-lg-0', 'placeholder' =>  __('messages.currency.currency_code'), 'required']) }}
        <div class="fv-plugins-message-container invalid-feedback"></div>
    </div>
    <div class="d-flex">
        <button type="submit" class="btn btn-primary">{{ __('crud.save') }}</button>&nbsp;&nbsp;&nbsp;
        <a href="{{ route('currencies.index') }}" type="reset"
           class="btn btn-light btn-active-light-primary me-2">@lang('crud.cancel')</a>
    </div>
</div>

