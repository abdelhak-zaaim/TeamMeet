<div class="row gx-10 mb-5">
    <div class="col-lg-12">
        <div class="mb-5">
            {{ Form::label('question', __('messages.faq.question').':', ['class' => 'form-label required']) }}
            {{ Form::text('question', null, ['class' => 'form-control', 'placeholder' => __('messages.faq.question'), 'required']) }}
        </div>
    </div>
    <div class="col-lg-12">
        <div class="mb-5">
            {{ Form::label('answer', __('messages.faq.answer').':', ['class' => 'form-label required']) }}
            {{ Form::textarea('answer', null, ['class' => 'form-control', 'placeholder' => __('messages.faq.answer'), 'required', 'rows'=> 5, 'maxLength' => '500']) }}
        </div>
    </div>
    <div class="d-flex">
        {{ Form::submit(__('messages.common.save'),['class' => 'btn btn-primary me-3','id'=>'faqSaveBtn']) }}
        <a href="{{ route('faqs.index') }}" type="reset"
           class="btn btn-secondary">{{__('messages.common.discard')}}</a>
    </div>
</div>
