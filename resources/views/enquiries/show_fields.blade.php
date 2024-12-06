<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6 d-flex flex-column mb-md-10 mb-5">
                <label for="name" class="pb-2 fs-4 text-gray-600">{{ __('messages.enquiry.name') }}:</label>
                <span class="fs-4 text-gray-800">{{$enquiry->full_name}}</span>
            </div>
            <div class="col-md-6 d-flex flex-column mb-md-10 mb-5">
                <label for="name" class="pb-2 fs-4 text-gray-600">{{ __('messages.enquiry.email') }}:</label>
                <span class="fs-4 text-gray-800">{{$enquiry->email}}</span>
            </div>
            <div class="col-md-6 d-flex flex-column mb-md-10 mb-5">
                <label class="pb-2 fs-4 text-gray-600">{{ __('messages.enquiry.registered_on')  }}</label>
                <span class="fs-4 text-gray-800">{{$enquiry->created_at->diffForHumans()}}</span>
            </div>
            <div class="col-md-6 d-flex flex-column mb-md-10 mb-5">
                <label class="pb-2 fs-4 text-gray-600">{{ __('messages.common.last_updated')  }}</label>
                <span class="fs-4 text-gray-800">{{$enquiry->updated_at->diffForHumans()}}</span>
            </div>
            <div class="col-md-12 d-flex flex-column mb-md-10 mb-5">
                <label class="pb-2 fs-4 text-gray-600">{{ __('messages.enquiry.message')  }}</label>
                <span class="fs-4 text-gray-800">{{ $enquiry->message }}</span>
            </div>
        </div>

    </div>
</div>
