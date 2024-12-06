<div class="row">
    <div class="col-md-6 d-flex flex-column mb-md-10 mb-5">
        <label for="name" class="pb-2 fs-4 text-gray-600">{{ __('messages.user.full_name') }}:</label>
        <span class="fs-4 text-gray-800">{{$user->full_name}}</span>
    </div>
    <div class="col-md-6 d-flex flex-column mb-md-10 mb-5">
        <label for="name" class="pb-2 fs-4 text-gray-600">{{ __('messages.user.email') }}:</label>
        <span class="fs-4 text-gray-800">{{$user->email}}</span>
    </div>
    <div class="col-md-6 d-flex flex-column mb-md-10 mb-5">
        <label for="name" class="pb-2 fs-4 text-gray-600">{{ __('messages.user.contact_number') }}:</label>
        <span class="fs-4 text-gray-800">
        {{ !empty($user->region_code) ? getCountryCode($user->region_code) : '' }}{{ !empty($user->phone_number) ? $user->phone_number : 'N/A'}}
        </span>
    </div>
    <div class="col-md-6 d-flex flex-column mb-md-10 mb-5">
        <label for="name" class="pb-2 fs-4 text-gray-600">{{ __('messages.user.gender') }}:</label>
        <span class="fs-4 text-gray-800">
{{!empty($user->gender) ?  \App\Models\User::GENDER[$user->gender] : 'N/A'}}
</span>
    </div>
    <div class="col-md-6 d-flex flex-column mb-md-10 mb-5">
        <label class="pb-2 fs-4 text-gray-600">{{ __('messages.common.created_on')  }}</label>
        <span class="fs-4 text-gray-800">{{$user->created_at->diffForHumans()}}</span>
    </div>
    <div class="col-md-6 d-flex flex-column mb-md-10 mb-5">
        <label class="pb-2 fs-4 text-gray-600">{{ __('messages.common.last_updated')  }}</label>
        <span class="fs-4 text-gray-800">{{$user->updated_at->diffForHumans()}}</span>
    </div>
</div>
