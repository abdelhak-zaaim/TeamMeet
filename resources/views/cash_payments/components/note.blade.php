@if(!empty($row->note))
    <a href="javascript:void(0)" class="text-decoration-none get-cash-payment-note" data-id="{{ $row->id }}"><i class="fa fa-eye"></i></a>
@else
    <span>{{ __('messages.common.n/a') }}</span>
@endif


