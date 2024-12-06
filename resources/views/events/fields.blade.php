<div class="row gx-10 mb-5">
    <div class="col-sm-6">
        <div class="mb-5">
            {{ Form::label('name', __('messages.event.event_name').':', ['class' => 'form-label required']) }}
            {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' =>  __('messages.event.event_name'),'required']) }}
        </div>
    </div>
    <div class="col-sm-6">
        {{ Form::label('event_location',__('messages.event.location').':' ,['class' => 'form-label required']) }}
        <div class="input-group mb-5">
            <select name="event_location" class="form-select form-select-solid event-location"
                    required id="eventLocationSelectBox">
                <option value="">{{ __('messages.event.add_location') }}</option>
                @foreach($locationArr as $key => $value)
                    <option value="{{ $key }}"
                            {{($key == old('event_location')) ? 'selected' : ''}} class="update-location"><i
                                class="fa fa-phone"></i>{{ $value }}</option>
                @endforeach
            </select>
            {{ Form::hidden('location_meta',null,['id' => 'locationAddData']) }}
        </div>
    </div>
    <div class="col-sm-8">
        {{ Form::label('event_link', __('messages.event.event_landing_page').':', ['class' => 'form-label required']) }}
        <div class="input-group mb-5">
            <span class="input-group-text"
                  id="basic-addon3">{{ getEventLandingLink() }}</span>
            {{ Form::text('event_link', null, ['class' => 'form-control eventlink', 'id' => 'eventLinkId', 'placeholder' => __('messages.event.event_landing_page'),'required']) }}
        </div>
    </div>
    <div class="col-sm-4">
        <div class="mb-5">
            {{ Form::label('event_color', __('messages.event.event_color').':', ['class' => 'form-label required']) }}
            <div class="color-wrapper"></div>
            {{ Form::text('event_color', '', ['id' => 'color', 'hidden', 'class' => 'form-control color']) }}
            <span id="colorError" class="text-danger"></span>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="mb-5">
            {{ Form::label('event_type', __('messages.event.event_type').':', ['class' => 'form-label required']) }}
            {{ Form::select('event_type', \App\Models\Event::EVENT_TYPE,null, ['class' => 'form-control payment-type', 'placeholder' => __('messages.placeholder.select_event_type'),'required', 'id' => 'paymentTypeId']) }}
        </div>
    </div>
    <div class="col-sm-6 {{ old('event_type') == 2 ? '' : 'd-none' }}" id="payableAmount">
        {{ Form::label('payable_amount', __('messages.event.payable_amount').':', ['class' => 'form-label required']) }}
        <div class="input-group mb-5">
            <span class="input-group-text"
                  id="basic-addon3">{{ getCurrencyIcon() }}</span>
            {{ Form::text('payable_amount', null, ['class' => 'form-control', 'placeholder' => __('messages.event.payable_amount'),'required','onkeyup' => 'if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,"")','id' => 'payableAmountId','disabled' => old('event_type') == 2 ? false : true]) }}
        </div>
    </div>
    <div class="col-sm-12 mb-5">
        {{ Form::label('description',__('messages.event.description').':' ,['class' => 'form-label']) }}
        {{  Form::textarea('description', null, ['class'=> 'form-control','rows'=> 5,'placeholder'=>__('messages.event.description') ])}}
    </div>
    <div class="d-flex">
        <button type="submit" class="btn btn-primary" id="btnSave">{{ __('messages.common.save') }}</button>&nbsp;&nbsp;&nbsp;
        <a href="{{ route('events.index') }}" type="reset"
           class="btn btn-secondary">{{ __('messages.common.discard') }}</a>
    </div>
</div>
