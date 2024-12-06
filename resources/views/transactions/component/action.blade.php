@php
   $showUrl =  getLogInUser()->hasRole('user') ? route('user.transactions.show',$row->id) : route('transactions.show',$row->id);
@endphp


<a href="{{ $showUrl }}" title="<?php echo __('messages.common.view') ?>" class="show-btn btn btn px-2 text-info fs-3 ps-0">
    <i class="fas fa-eye fs-4"></i>
</a>
