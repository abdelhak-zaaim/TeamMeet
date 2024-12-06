@if ($row->status == 1)
    <span class="badge bg-light-success">{{ __('messages.subscription_transaction.paid') }}</span>
@else
    <span class="badge bg-light-success">{{ __('messages.subscription_transaction.pending') }}</span>
@endif
