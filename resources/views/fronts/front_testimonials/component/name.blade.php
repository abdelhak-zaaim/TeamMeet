<div class="d-flex align-items-center">
    <div class="image image-circle image-mini me-3">
        <a href="#">
            <div class="">
                <img src="{{ $row->front_profile }}" alt="" class="user-img rounded-circle object-cover" loading="lazy">
            </div>
        </a>
    </div>
    <div class="d-flex flex-column">
        <a class="text-decoration-none mb-1">{{ $row->name }}</a>
        <span>{{ $row->designation }}</span>
    </div>
</div>
