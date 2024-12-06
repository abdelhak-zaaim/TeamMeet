@if($row->subscription_status == \App\Models\UserTransaction::APPROVED)
    <span class="badge bg-success">{{ \App\Models\UserTransaction::SUBSCRIPTION_STATUS_ARR[$row->subscription_status] }}</span>
@elseif($row->subscription_status == \App\Models\UserTransaction::REJECTED)
    <span class="badge bg-danger">{{ \App\Models\UserTransaction::SUBSCRIPTION_STATUS_ARR[$row->subscription_status] }}</span>
@else
    <div class="d-flex align-items-center" wire:ignore>
        {{ Form::select('subscription_status',\App\Models\UserTransaction::SUBSCRIPTION_STATUS_ARR, $row->subscription_status,['class' => 'form-control subscription-status change-subscription-status','data-id' => $row->id]) }}
    </div>
@endif
