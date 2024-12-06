<div class="col-12 calendar mt-5">
    <div class="d-md-flex card shadow-sm p-6 flex-md-row">
        <div class="col-lg-3 col-md-2 mt-5 mb-5">
            <div class="d-flex justify-content-center align-content-center">
                <img src="{{ asset(getSettingData()['logo']) }}" alt="app-logo" class="logo">
            </div>
            <hr>
            <div class="calendar__user-detail ms-4 d-flex flex-column align-items-md-start align-items-center">
                <img src="{{ $event->user->profile_image }}" alt="user-profile"
                     class="rounded-circle img-fluid object-cover">
                <div class="calendar__event-detail mt-3 mb-5">
                    <span class="d-block text-md-start text-center">{{ $event->user->full_name }}</span>
                    <h1 class="mt-1 text-md-start text-center">{{ $event->name }}</h1>
                </div>
                <div class="d-flex">
                    <i class="fa fa-clock fs-1"></i><span class="justify-content-center align-content-center ms-3">{{ $event->slot_time }} min</span>
                </div>
                <div class="d-flex mt-3">
                    <i class="fa fa-video fs-1"></i><span
                            class="justify-content-center align-content-center ms-3">{!! $event->description !!}</span>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 calendar__card mt-sm-0 mt-5">
            <div class="calendar__header d-flex align-items-center justify-content-between">
                <a href="javascript:void(0)" data-prev-month="{{ $prevMonth }}" id="prevMonth">
                    <div class="calendar__prev-arrow rounded-circle d-flex align-items-center justify-content-center">
                        <span class="prev-arrow"></span>
                    </div>
                </a>
                <div class="calendar__month-title">
                    <span>{{ $periods->first()->translatedFormat('F') }} {{ $periods->first()->format('Y') }}</span>
                </div>
                <a href="javascript:void(0)" data-next-month="{{ $nextMonth }}" id="nextMonth">
                    <div class="calendar__next-arrow rounded-circle d-flex align-items-center justify-content-center">
                        <span class="next-arrow"></span>
                    </div>
                </a>
            </div>
            <div class="calendar__body mt-5">
                <div class="container">
                    <div class="d-md-block d-none">
                        <div class="row row-cols-7">
                            @for($i = 1; $i <= getEmptyDays($periods->first()->format('l')); $i++)
                                <div class="col"></div>
                            @endfor
                            @foreach($periods as $key => $period)
                                @if ($period->format('l') == 'Sunday')
                                    <div class="col">
                                        <a href="javascript:void(0)" class="get-slots text-decoration-none"
                                           date-slot-date="{{ $period }}">
                                            <div class="calendar__date fs-6 d-flex flex-column {{ checkActiveSelectedClass($defaultDate, $period, $slotDaysArr) }}">
                                                <span>{{ $period->format('d') }}</span>
                                                <h6>{{ __('messages.common.sun') }}</h6>
                                            </div>
                                        </a>
                                    </div>
                                @elseif ($period->format('l') == 'Monday')
                                    <div class="col">
                                        <a href="javascript:void(0)" class="get-slots text-decoration-none"
                                           date-slot-date="{{ $period }}">
                                            <div class="calendar__date fs-6 d-flex flex-column {{ checkActiveSelectedClass($defaultDate, $period, $slotDaysArr) }}">
                                                <span>{{ $period->format('d') }}</span>
                                                <h6>{{ __('messages.common.mon') }}</h6>
                                            </div>
                                        </a>
                                    </div>
                                @elseif ($period->format('l') == 'Tuesday')
                                    <div class="col">
                                        <a href="javascript:void(0)" class="get-slots text-decoration-none"
                                           date-slot-date="{{ $period }}">
                                            <div class="calendar__date fs-6 d-flex flex-column {{ checkActiveSelectedClass($defaultDate, $period, $slotDaysArr) }}">
                                                <span>{{ $period->format('d') }}</span>
                                                <h6>{{ __('messages.common.tue') }}</h6>
                                            </div>
                                        </a>
                                    </div>
                                @elseif ($period->format('l') == 'Wednesday')
                                    <div class="col">
                                        <a href="javascript:void(0)" class="get-slots text-decoration-none"
                                           date-slot-date="{{ $period }}">
                                            <div class="calendar__date fs-6 d-flex flex-column {{ checkActiveSelectedClass($defaultDate, $period, $slotDaysArr) }}">
                                                <span>{{ $period->format('d') }}</span>
                                                <h6>{{ __('messages.common.wed') }}</h6>
                                            </div>
                                        </a>
                                    </div>
                                @elseif ($period->format('l') == 'Thursday')
                                    <div class="col">
                                        <a href="javascript:void(0)" class="get-slots text-decoration-none"
                                           date-slot-date="{{ $period }}">
                                            <div class="calendar__date fs-6 d-flex flex-column {{ checkActiveSelectedClass($defaultDate, $period, $slotDaysArr) }}">
                                                <span>{{ $period->format('d') }}</span>
                                                <h6>{{ __('messages.common.thu') }}</h6>
                                            </div>
                                        </a>
                                    </div>
                                @elseif ($period->format('l') == 'Friday')
                                    <div class="col">
                                        <a href="javascript:void(0)" class="get-slots text-decoration-none"
                                           date-slot-date="{{ $period }}">
                                            <div class="calendar__date fs-6 d-flex flex-column {{ checkActiveSelectedClass($defaultDate, $period, $slotDaysArr) }}">
                                                <span>{{ $period->format('d') }}</span>
                                                <h6>{{ __('messages.common.fri') }}</h6>
                                            </div>
                                        </a>
                                    </div>
                                @elseif ($period->format('l') == 'Saturday')
                                    <div class="col">
                                        <a href="javascript:void(0)" class="get-slots text-decoration-none"
                                           date-slot-date="{{ $period }}">
                                            <div class="calendar__date fs-6 d-flex flex-column {{ checkActiveSelectedClass($defaultDate, $period, $slotDaysArr) }}">
                                                <span>{{ $period->format('d') }}</span>
                                                <h6>{{ __('messages.common.sat') }}</h6>
                                            </div>
                                        </a>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <div class="d-md-none d-block">
                        <div class="row row-cols-7 mobile-calendar">
                            @foreach($periods as $key => $period)
                                @if ($period->format('l') == 'Sunday')
                                    <div class="col">
                                        <a href="javascript:void(0)" class="get-slots text-decoration-none"
                                           date-slot-date="{{ $period->format('Y-m-d') }}">
                                            <div class="calendar__date fs-6 d-flex flex-column {{ checkActiveSelectedClass($defaultDate, $period, $slotDaysArr) }}">
                                                <span>{{ $period->format('d') }}</span>
                                                <h6>{{ __('messages.common.sun') }}</h6>
                                            </div>
                                        </a>
                                    </div>
                                @elseif ($period->format('l') == 'Monday')
                                    <div class="col">
                                        <a href="javascript:void(0)" class="get-slots text-decoration-none"
                                           date-slot-date="{{ $period->format('Y-m-d') }}">
                                            <div class="calendar__date fs-6 d-flex flex-column {{ checkActiveSelectedClass($defaultDate, $period, $slotDaysArr) }}">
                                                <span>{{ $period->format('d') }}</span>
                                                <h6>{{ __('messages.common.mon') }}</h6>

                                            </div>
                                        </a>
                                    </div>
                                @elseif ($period->format('l') == 'Tuesday')
                                    <div class="col">
                                        <a href="javascript:void(0)" class="get-slots text-decoration-none"
                                           date-slot-date="{{ $period->format('Y-m-d') }}">
                                            <div class="calendar__date fs-6 d-flex flex-column {{ checkActiveSelectedClass($defaultDate, $period, $slotDaysArr) }}">
                                                <span>{{ $period->format('d') }}</span>
                                                <h6>{{ __('messages.common.tue') }}</h6>

                                            </div>
                                        </a>
                                    </div>
                                @elseif ($period->format('l') == 'Wednesday')
                                    <div class="col">
                                        <a href="javascript:void(0)" class="get-slots text-decoration-none"
                                           date-slot-date="{{ $period->format('Y-m-d') }}">
                                            <div class="calendar__date fs-6 d-flex flex-column {{ checkActiveSelectedClass($defaultDate, $period, $slotDaysArr) }}">
                                                <span>{{ $period->format('d') }}</span>
                                                <h6>{{ __('messages.common.wed') }}</h6>
                                            </div>
                                        </a>
                                    </div>
                                @elseif ($period->format('l') == 'Thursday')
                                    <div class="col">
                                        <a href="javascript:void(0)" class="get-slots text-decoration-none"
                                           date-slot-date="{{ $period->format('Y-m-d') }}">
                                            <div class="calendar__date fs-6 d-flex flex-column {{ checkActiveSelectedClass($defaultDate, $period, $slotDaysArr) }}">
                                                <span>{{ $period->format('d') }}</span>
                                                <h6>{{ __('messages.common.thu') }}</h6>
                                            </div>
                                        </a>
                                    </div>
                                @elseif ($period->format('l') == 'Friday')
                                    <div class="col">
                                        <a href="javascript:void(0)" class="get-slots text-decoration-none"
                                           date-slot-date="{{ $period->format('Y-m-d') }}">
                                            <div class="calendar__date fs-6 d-flex flex-column {{ checkActiveSelectedClass($defaultDate, $period, $slotDaysArr) }}">
                                                <span>{{ $period->format('d') }}</span>
                                                <h6>{{ __('messages.common.fri') }}</h6>
                                            </div>
                                        </a>
                                    </div>
                                @elseif ($period->format('l') == 'Saturday')
                                    <div class="col">
                                        <a href="javascript:void(0)" class="get-slots text-decoration-none"
                                           date-slot-date="{{ $period->format('Y-m-d') }}">
                                            <div class="calendar__date fs-6 d-flex flex-column {{ checkActiveSelectedClass($defaultDate, $period, $slotDaysArr) }}">
                                                <span>{{ $period->format('d') }}</span>
                                                <h6>{{ __('messages.common.sat') }}</h6>
                                            </div>
                                        </a>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-4  mt-5">
            <h6 class="select-slot-date ms-3">{{ ucfirst(__('messages.common.'.strtolower($month->format('M')))) }} {{$month->format('d, Y')}}</h6>
            <div class="calendar__task-list">
                <div class="to-do-card pt-sm-2 pt-4">
                    <div class="to-do-card-content position-relative d-flex flex-column align-items-center ms-2">
                        @if(!empty($data))
                            @foreach($data as $val)
                                <div class="inner-card shadow-sm py-3 py-sm-0 mb-4">
                                    <a href="{{ url('s').'/'.$event->user->domain_url.'/'.$event->event_link.'/'.$val['date'].'?time='.$val['time'].'&originalTime='.$val['originalTime'] }}"
                                       class="text-decoration-none text-black" data-turbo="false">
                                        <div class="event-container d-flex align-items-center mb-0">
                                            <div class="event-icon">
                                                <div class="event-bullet-event"></div>
                                            </div>
                                            <div class="event-info">
                                                <p class="mb-1 time">{{  $val['time']}}</p>
                                                <p class="mb-0 fs-6">{{ $val['timeWithTimezone'] }}</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        @else
                            <p class="text-center fs-2">{{ __('messages.common.no_time_slot_available') }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
