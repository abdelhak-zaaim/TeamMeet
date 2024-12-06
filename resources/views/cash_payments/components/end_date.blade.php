@if(!empty($row->transactionSubscription))
    <span class="badge bg-light-info">{{ \Carbon\Carbon::parse($row->transactionSubscription->ends_at)->isoFormat('Do MMMM YYYY') }}</span>
@else
    <span>{{ __('messages.common.n/a') }}</span>
@endif
