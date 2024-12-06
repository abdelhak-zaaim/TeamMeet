@if(!empty($row->payment_attachment))
    <a href="{{ route('download.attachment', $row->media[0]->id) }}" class="text-decoration-none">{{ __('messages.cash_payment.download') }}</a>
@else
    <span>{{ __('messages.common.n/a') }}</span>
@endif
