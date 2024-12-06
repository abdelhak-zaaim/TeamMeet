@if($row->personalExperience== null)
    {{__('messages.common.n/a')}}
@else
{{$row->personalExperience->name}}
@endif
