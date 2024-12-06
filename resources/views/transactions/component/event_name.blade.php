@if(getLogInUser()->hasRole('admin')) 
{{$row->scheduleEvent->event->name }}
@else
<a href="{{route('events.show', $row->scheduleEvent->event->id)}}" class="text-decoration-none">{{$row->scheduleEvent->event->name}}</a>
@endif
