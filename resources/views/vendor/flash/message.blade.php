@foreach (session('flash_notification', collect())->toArray() as $message)
    @if ($message['overlay'])
        @include('flash::modal', [
            'modalClass' => 'flash-modal',
            'title'      => $message['title'],
            'body'       => $message['message']
        ])
    @else
        <div class="alert alert-{{ $message['level'] }} {{ $message['important'] ? 'alert-important' : '' }} custom-message">
            <div class="d-flex text-white align-items-center">
                @if($message['level'] == 'success')
                    <i class="fa-solid fa-face-smile me-5"></i>
                @elseif($message['level'] == 'warning')
                    <i class="fa-solid fa-face-meh me-5"></i>
                @elseif($message['level'] == 'danger')
                    <i class="fa-solid fa-face-frown me-5"></i>
                @else
                    <i class="fa-solid fa-face-smile me-5"></i>
                @endif
                <div>
                    <span class="fs-4 text-white d-flex align-items-center">{{ $message['message'] }}</span>
                </div>
            </div>
        </div>
    @endif
@endforeach

{{ session()->forget('flash_notification') }}
