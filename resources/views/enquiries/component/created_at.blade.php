<div class="badge bg-info">
    <div> {{ \Carbon\Carbon::parse($row->created_at)->isoFormat('Do MMMM, YYYY H:m A')}}</div>
</div>
