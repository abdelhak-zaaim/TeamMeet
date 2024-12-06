@if(!empty($row->region_code) && !empty($row->phone_number))
    <span>{{ getCountryCode($row->region_code).$row->phone_number}}</span>
@else
    <span>{{ __('messages.common.n/a') }}</span>
@endif

