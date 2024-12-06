<div class="ms-auto" wire:ignore>
    <div class="ms-0 ms-md-2">
        <div class="dropdown d-flex align-items-center me-4 me-md-5">
            <button class="btn btn-icon btn-outline-primary"
                    type="button" data-bs-auto-close="outside"
                    data-bs-toggle="dropdown" aria-expanded="false"
                    id="enquiryStatusFilterBtn">
                <i class='fas fa-filter'></i>
            </button>
            <div class="dropdown-menu py-0" aria-labelledby="personalExpFilterBtn">
                <div class="text-start border-bottom py-4 px-7">
                    <h3 class="text-gray-900 mb-0">{{ __('messages.common.filter_options') }}</h3>
                </div>
                <div class="p-5">
                    <div class="mb-5">
                        <label for="exampleInputSelect2"
                               class="form-label">{{ __('messages.common.status').':' }}</label>
                        {{ Form::select('status', \App\Models\Enquiry::VIEW_NAME, \App\Models\Enquiry::ALL, ['id' => 'enquiryStatusFilter','class' => 'form-select enquiry-status-filter', 'placeholder' => __('messages.enquiry.select_status')]) }}
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="reset" id="resetEnquiryStatusFilter"
                                class="btn btn-secondary">{{ __('messages.common.reset') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
