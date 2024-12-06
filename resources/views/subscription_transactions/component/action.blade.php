@php
   $route = getLogInUser()->hasRole('user') ? route('user.subscription.transactions.show',$row->id) : route('subscription.transactions.show',$row->id)
@endphp

<a href="{{ $route }}" title="<?php echo __('messages.common.view') ?>" class="show-btn btn btn px-2 text-info fs-3 ps-0">
    <i class="fas fa-eye fs-4"></i>
</a>
