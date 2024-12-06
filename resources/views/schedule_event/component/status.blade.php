@php
    $statusColorArr = [
        '1' => 'success',
        '2'=>'info',
        '3'=>'danger',    
    ]
@endphp
<span class="badge bg-{{$statusColorArr[$row->status]}}">{{ App\Models\EventSchedule::STATUS[$row->status] }}</span>
