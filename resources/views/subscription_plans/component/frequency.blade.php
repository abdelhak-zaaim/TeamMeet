@if ($row->frequency == 1)
    {{ __('messages.common.month') }}
@elseif($row->frequency == 2)
    {{__('messages.common.year')}}
@else
    {{__('messages.common.unlimited')}}
@endif
