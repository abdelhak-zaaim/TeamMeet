<div class="row">
    <div class="col-end-12">
        <div class="d-flex flex-column flex-sm-row flex-nowrap align-items-sm-center justify-content-sm-between">
            <div class="row">
                @if(count($events) > 0 || !empty($search))
                    <div class="position-relative d-flex align-items-center width-320">
                        <span class="position-absolute d-flex align-items-center top-0 bottom-0 left-0 text-gray-600 ms-3">
                           <i class="fa-solid fa-magnifying-glass"></i>
                        </span>
                        <input wire:model.debounce.100ms.live="search" type="search" autocomplete="off"
                               class="form-control ps-8"
                               id="search" placeholder="{{ __('messages.common.search') }}" aria-label="Search">
                    </div>
                @endif
            </div>
            <a type="button" class="btn btn-primary mt-3" href="{{ route('events.create')}}" data-turbo="false">
                {{ __('messages.event.add_event') }}</a>
        </div>
        @if(count($events) > 0)
            <div class="content">
                <div class="position-relative">
                    @php
                        $styleCss = 'style';
                    @endphp
                    <div class="row g-3 mt-0">
                        @foreach($events as $event)
                            <div class="col-md-6 col-lg-6 col-12 col-xl-4">
                                <div class="card mb-6" {{ $styleCss }}="
                                    border-top: 5px solid {{ $event->event_color }}">
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <a href="{{ route('events.show', $event->id) }}"
                                           class="fs-4 mb-1 text-decoration-none text-gray-900 text-hover-primary">{{ $event->name }}</a>
                                        <div>
                                            <a href="{{ route('events.edit', $event->id) }}" title="{{ __('messages.common.edit') }}"
                                               data-turbo="false"
                                               class="edit-btn btn px-2 text-primary fs-3 ps-0">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            <a href="javascript:void(0)" title="{{ __('messages.common.delete') }}" data-id="{{ $event->id }}"
                                               class="event-delete-btn btn px-2 text-danger fs-3 ps-0 ">
                                                <i class="fa-solid fa-trash"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="fs-6 fw-bold text-gray-600 mb-3">{{ $event->slot_time }}
                                        Min
                                    </div>
                                    @php($shareEventLink = Request::root().'/s/'.getLogInUser()->domain_url.'/'.$event->event_link)
                                    <div class="d-flex justify-content-between mb-5">
                                        <div class="fs-6 fw-bold text-gray-600"><a
                                                    href="{{ $shareEventLink }}"
                                                    target="_blank"
                                                    class="text-decoration-none">{{ __('messages.event.view_booking_page') }}</a>
                                        </div>
                                        <div class="form-check form-switch me-2">
                                            <label title="{{ __('messages.common.status') }}">
                                                <input class="form-check-input h-20px w-30px event-status"
                                                       data-id="{{ $event->id }}"
                                                       type="checkbox" {{ $event->status == 1 ? 'checked' : '' }}>
                                            </label>
                                        </div>
                                    </div>
                                    <?php
                                    $styleCss = 'style';
                                    ?>
                                    <div class="d-flex mt-3 align-content-center justify-content-between">
                                        <div class="dropdown d-flex align-items-center justify-content-end">
                                            <a type="button" class="btn btn-sm btn-primary" id="dropdownMenuButton1"
                                               data-bs-toggle="dropdown"
                                               aria-expanded="true">{{ __('messages.event.share') }}</a>
                                            <div class="dropdown-menu my-2 mx-2" aria-labelledby="dropdownMenuButton1"
                                                 data-popper-placement="bottom-end">
                                                <div class="social-icon-list d-flex justify-content-center p-1">
                                                    <a href="http://www.facebook.com/sharer.php?u={{ $shareEventLink }}"
                                                       target="_blank" class="mx-2" title="Facebook">
                                                        <img src="{{ asset('web/images/social-icon-images/facebook.png') }}"
                                                             class="h-20px img-fluid">
                                                    </a>
                                                    <a href="https://www.instagram.com/sharer.php?u={{$shareEventLink}}"
                                                       class="mx-2" target="_blank">
                                                        <img src="{{ asset('web/images/social-icon-images/instagram.png') }}"
                                                             class="h-20px img-fluid">
                                                    </a>
                                                    <a href="https://wa.me/?text={{ $shareEventLink }}" target="_blank" class="mx-2 share10" title="Whatsapp">
                                                        <i class="fab fa-whatsapp fa-1x" style="color: limegreen"></i>
                                                    </a>
                                                    <a href="http://twitter.com/share?url={{$shareEventLink}}&text={{ $event->name }}&hashtags=sharebuttons"
                                                       target="_blank" class="mx-2" title="Twitter">
                                                        <img src="{{ asset('web/images/social-icon-images/new-twitter-logo.png') }}"
                                                             class="h-20px img-fluid">
                                                    </a>
                                                    <a href="http://www.linkedin.com/shareArticle?mini=true&url={{$shareEventLink}}"
                                                       target="_blank" class="mx-2" title="Linkedin">
                                                        <img src="{{ asset('web/images/social-icon-images/linkedin.png') }}"
                                                             class="h-20px img-fluid">
                                                    </a>
                                                    <a href="mailto:?Subject={{ $event->name }}&Body=This%20is%20your%20schedule%20event%20link%20:%20 {{$shareEventLink}}"
                                                       class="mx-2" title="Gmail">
                                                        <img src="{{ asset('web/images/social-icon-images/gmail.png') }}"
                                                             class="h-20px img-fluid">
                                                    </a>
                                                    <a href="http://pinterest.com/pin/create/link/?url={{$shareEventLink}}"
                                                       class="mx-2" target="_blank">
                                                        <img src="{{ asset('web/images/social-icon-images/pinterest.png') }}"
                                                             class="h-20px img-fluid">
                                                    </a>
                                                    <a href="http://reddit.com/submit?url={{ $shareEventLink }}&title={{ $event->name }}"
                                                       target="_blank" class="mx-2" title="Reddit">
                                                        <img src="{{ asset('web/images/social-icon-images/reddit.png') }}"
                                                             class="h-20px img-fluid">
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="symbol-group ms-0 symbol-hover my-1">
                                            <a href="javascript:void(0)" class="copy-link text-decoration-none"data-link="{{ $shareEventLink }}">
                                                <i class="fa fa-copy me-1" {{ $styleCss }}="color: #009ef7"></i>
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
