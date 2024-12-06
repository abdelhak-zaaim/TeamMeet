<div class="d-flex align-items-center">
    <div class="image image-circle image-mini me-3">
        <a href="#">
            <div class="">
                <img src="{{$row->profile_image}}" alt="" class="user-img rounded-circle object-cover">
            </div>
        </a>
    </div>
    <div class="d-flex flex-column">
        <a href="{{route('users.show',$row->id)}}" class="text-decoration-none mb-1">{{$row->full_name}}</a>
        <span>{{$row->email}}</span>
    </div>
</div>
