<div class="modal fade" id="changeLanguageModal" aria-modal="true" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3>{{ __('messages.user.change_language') }}</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>
            {{ Form::open(['id'=>'changeLanguageForm']) }}
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="alert alert-danger d-none" id="editLanguageValidationErrorsBox"></div>
                    <div>
                            {{ Form::label('Language', __('messages.language').':',['class' => 'form-label']) }}
                        {{ Form::select('language',App\Models\User::LANGUAGES, (getLoginUser()!==null) ? getLoginUser()->language : null, ['class' => 'form-select select-language','id' => 'selectLanguage']) }}
                    </div>
                </div>
                <div class="modal-footer pt-0">
                {{ Form::button(__('messages.common.save'),['class' => 'btn btn-primary m-0','id' => 'languageChangeBtn','type'=>'submit']) }}
                    {{ Form::button(__('messages.common.discard'),['class' => 'btn btn-secondary my-0 ms-5 me-0','data-bs-dismiss' => 'modal']) }}
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
