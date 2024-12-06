@if(strlen($row->message) >= 55)
    {{ mb_substr($row->message,0,55).'...' }}
@else
    {{ $row->message }}
@endif

