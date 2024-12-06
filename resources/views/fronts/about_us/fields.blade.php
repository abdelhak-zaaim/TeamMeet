<div class="row gx-10 mb-5">
    <div class="col-lg-12">
        <div class="mb-5">
            {{ Form::label('about_us_title', __('messages.about_us.title').':', ['class' => 'form-label required ']) }}
            {{ Form::text('about_us_title', $aboutUs['about_us_title'], ['class' => 'form-control', 'placeholder' => __('messages.about_us.title'), 'required', 'maxLength' => 70]) }}
        </div>
    </div>
    <div class="col-lg-12">
        <div class="mb-5">
            {{ Form::label('about_us_description', __('messages.about_us.description').':', ['class' => 'form-label required ']) }}
            <div id="aboutUsDescriptionId" class="editor-height"></div>
            {{ Form::hidden('about_us_description', null, ['id' => 'aboutUsDescription']) }}
        </div>
    </div>
</div>
<div class="d-flex">
    {{ Form::submit(__('messages.common.save'),['class' => 'btn btn-primary me-2','id'=>'aboutUsSaveBtn']) }}
</div>

