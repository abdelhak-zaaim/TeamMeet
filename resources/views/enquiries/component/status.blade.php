@if ($row->view) 
<div class="badge bg-success">{{$row->view_name}}</div>
@else
<div class="badge bg-danger">{{$row->view_name}}</div>
@endif
