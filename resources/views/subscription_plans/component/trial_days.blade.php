@if ($row->trial_days != 0)
{{ $row->trial_days .' ' . 'Days' }}
@else
{{__('messages.common.n/a')}}
@endif
