<a href="{{ route('subscription-plans.show',$row->id) }}" title="<?php echo __('messages.common.view') ?>"
   class="show-btn btn btn px-2 text-info fs-3 ps-0">
    <i class="fas fa-eye fs-4"></i>
</a>
<a href="{{ route('subscription-plans.edit',$row->id) }}" title="<?php echo __('messages.common.edit') ?>
        " class="edit-btn btn px-2 text-primary fs-3 ps-0" data-id="{{$row->id}}">
    <i class="fa-solid fa-pen-to-square"></i>
</a>

@php
    $isDefault = $row->is_default == 0 ? true : false;
    $checkActive = $row->subscriptions->count()
@endphp

@if($isDefault && $checkActive == 0)
    <a href="javascript:void(0)" title="<?php echo __('messages.common.delete') ?>" data-id="{{$row->id}}"
       class="subscription-plan-delete-btn btn px-2 text-danger fs-3 ps-0 ">
        <i class="fa-solid fa-trash"></i>
    </a>
@endif
