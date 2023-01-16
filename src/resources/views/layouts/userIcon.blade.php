@if (!empty($user_icon_image))
    <img class="user-icon" src="{{asset('storage/sample/' . $user_icon_image)}}" alt="{{$user_icon_image}}" width="100">
@else
    <img class="user-icon" src="{{asset('images/no_user.png')}}" alt="no_user.png" width="100">
@endif