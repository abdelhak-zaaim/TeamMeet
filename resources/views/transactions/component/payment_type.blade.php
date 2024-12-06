@if ($row !== null && $row->type == 1)
    <div class="badge bg-light-success">{{__('messages.setting.stripe')}}</div>
@elseif ($row !== null && $row->type == 2)
    <div class="badge bg-light-primary">{{__('messages.setting.paypal')}}</div>
@elseif ($row !== null && $row->type == 3)
    <div class="badge bg-light-primary">{{__('messages.setting.paystack')}}</div>
@elseif ($row !== null && $row->type == 4)
    <div class="badge bg-light-primary">{{__('messages.setting.razorpay')}}</div>
@else
    {{__('messages.common.n/a')}}
@endif
