@php
    $statusColorArr = [ 
    '1' => 'info',
    '2' => 'success'
    ]
@endphp
<span class="badge bg-{{ $statusColorArr[$row->event->event_type] }}">{{ App\Models\Event::EVENT_TYPE[$row->event->event_type]}}</span>
