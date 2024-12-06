<div class="row">
    <div class="col-end-12">
        @if(count($events) > 0)
            <div class="content">
                <div class="position-relative">
                    @php
                        $styleCss = 'style';
                    @endphp
                    <div class="row g-3 mt-0">
                        @foreach($events as $event)
                            <div class="col-md-6 col-lg-6 col-12 col-xl-4 d-flex text-center flex-column">
                                <div class="card mb-6" {{ $styleCss }}="
                                    border-top: 5px solid {{ $event->event_color }}">
                                <div class="card-body">
                                    <div class="mb-3">
                                        <a href=""
                                           class="fs-4 mb-1 text-decoration-none text-dark">{{ $event->name }}</a>
                                    </div>
                                    <div class="fs-6 fw-bold text-gray-600 mb-3">{{ $event->slot_time }}
                                        {{ __('messages.min') }}
                                    </div>
                                    @php($EventLink = Request::root().'/s/'.$event->user->domain_url.'/'.$event->event_link)
                                    <div class="d-flex justify-content-between">
                                        <div class="d-flex justify-content-between">
                                            <div class="fs-6 fw-semibold text-gray-600"><a
                                                        href="{{ $EventLink }}"
                                                        target="_blank"
                                                        class="text-decoration-none text-light">{{ __('messages.event.view_booking_page') }}</a>
                                            </div>
                                        </div>
                                        <?php
                                        $styleCss = 'style';
                                        ?>
                                        <div class="symbol-group ms-0 symbol-hover my-1">
                                            <a href="javascript:void(0)" class="copy-link text-decoration-none" data-link="{{ $EventLink }}">
                                                <i class="fa fa-copy me-1" {{ $styleCss }}="color: #8BC34A"></i>
                                               {{ __('messages.event.copy_link') }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @if($events->count() > 0)
                <div class="mt-0 mb-5 col-12">
                    <div class="row paginatorRow">
                        <div class="col-lg-2 col-md-6 col-sm-12 pt-2">
                                    <span class="d-inline-flex">
                                        {{ __('messages.common.showing') }}
                                        <span class="font-weight-bold mx-1">{{ $events->firstItem() }}</span> -
                                        <span class="font-weight-bold mx-1">{{ $events->lastItem() }}</span> <span>{{ __('messages.common.of') }}</span>
                                        <span class="font-weight-bold mx-1">{{ $events->total() }}</span>
                                    </span>
                        </div>
                        <div class="col-lg-10 col-md-6 col-sm-12 d-flex justify-content-end">
                            {{ $events->links() }}
                        </div>
                    </div>
                </div>
            @endif
    </div>
    @else
        <div class="col-lg-12 col-md-12">
            @if(empty($search))
                <h2 class="custom-align-center">{{ __('messages.event.no_event_available') }}</h2>
            @else
                <h2 class="custom-align-center">{{ __('messages.event.no_event_found') }}</h2>
            @endif
        </div>
    @endif
</div>
</div>
