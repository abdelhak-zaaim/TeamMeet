<a href="{{ route('admins.edit',$row->id) }}" title="<?php echo __('messages.common.edit') ?>"
   class="btn px-2 text-primary fs-3 ps-0">
    <i class="fa-solid fa-pen-to-square"></i>
</a>

@if($row->id != getLogInUserId())
    <a href="javascript:void(0)" title="<?php echo __('messages.common.delete') ?>" data-id="{{$row->id}}"
       class="admin-delete-btn btn px-2 text-danger fs-3 ps-0 ">
        <i class="fa-solid fa-trash"></i>
    </a>
@endif
