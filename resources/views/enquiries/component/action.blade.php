<a href="{{ route('enquiries.show',$row->id) }}" title="<?php echo __('messages.common.view') ?>"
   class="show-btn btn btn px-2 text-info fs-3 ps-0">
    <i class="fas fa-eye fs-4"></i>
</a>

<a href="javascript:void(0)" title="<?php echo __('messages.common.delete') ?>" data-id="{{$row->id}}"
   class="enquiry-delete-btn btn px-2 text-danger fs-3 ps-0 ">
    <i class="fa-solid fa-trash"></i>
</a>
