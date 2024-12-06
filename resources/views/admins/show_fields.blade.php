<div class="row">
    <div class="col-md-6 d-flex flex-column mb-md-10 mb-5">
        <label for="name" class="pb-2 fs-4 text-gray-600">{{ __('messages.common.name') }}:</label>
        <span class="fs-4 text-gray-800">{{$admin->full_name}}</span>
    </div>
    <div class="col-md-6 d-flex flex-column mb-md-10 mb-5">
        <label for="name" class="pb-2 fs-4 text-gray-600">{{ __('messages.admin.email') }}:</label>
        <span class="fs-4 text-gray-800">{{$admin->email}}</span>
    </div>
    <div class="col-md-6 d-flex flex-column mb-md-10 mb-5">
        <label for="name" class="pb-2 fs-4 text-gray-600">{{ __('messages.admin.contact_number') }}:</label>
        <span class="fs-4 text-gray-800">
            {{ !empty($admin->region_code) ? getCountryCode($admin->region_code) : '' }}{{ !empty($admin->phone_number) ? $admin->phone_number : 'N/A'}}
        </span>
    </div>
    <div class="col-md-6 d-flex flex-column mb-md-10 mb-5">
        <label for="name" class="pb-2 fs-4 text-gray-600">{{ __('messages.admin.gender') }}:</label>
        <span class="fs-4 text-gray-800">
            {{!empty($admin->gender) ?  \App\Models\User::GENDER[$admin->gender] : 'N/A'}}
        </span>
    </div>
    <div class="col-md-6 d-flex flex-column mb-md-10 mb-5">
        <label class="pb-2 fs-4 text-gray-600">{{ __('messages.common.created_on')  }}</label>
        <span class="fs-4 text-gray-800">{{$admin->created_at->diffForHumans()}}</span>
    </div>
    <div class="col-md-6 d-flex flex-column mb-md-10 mb-5">
        <label class="pb-2 fs-4 text-gray-600">{{ __('messages.common.last_updated')  }}</label>
        <span class="fs-4 text-gray-800">{{$admin->updated_at->diffForHumans()}}</span>
    </div>
</div>
