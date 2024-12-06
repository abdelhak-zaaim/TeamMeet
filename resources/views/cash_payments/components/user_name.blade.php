<div class="d-flex align-items-center">
    <div class="image image-circle image-mini me-3">
        <a href="#">
            <div class="">
                <img src="{{$row->user->profile_image}}" alt="" class="user-img rounded-circle object-cover">
            </div>
        </a>
    </div>
    <div class="d-flex flex-column">
        <a href="{{route('users.show',$row->user->id)}}" class="text-decoration-none mb-1">{{$row->user->full_name}}</a>
        <span>{{$row->user->email}}</span>
    </div>
</div>
