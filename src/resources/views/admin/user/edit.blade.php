@extends('layouts.adminApp')

@section('content')
@include('layouts.adminSidebar')
<div class="admin-main-container">
    <h1>ユーザー情報</h1>

    {{-- バリデーションエラーの表示 --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.user.update', $user->user_id) }}" enctype="multipart/form-data">
        @csrf

        <input type="hidden" name="_method" value="PUT">

        <label for="user_icon_image" >{{ __('アイコン画像') }}</label>
        @include('layouts.userIcon', ['user_icon_image'=>$user->user_icon_image])
        <div>
            <input id="user_icon_image" type="file" name="user_icon_image" value="{{ $user->user_icon_image }}">

            @error('user_icon_image')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <label for="user_name" >{{ __('名前') }}</label>

        <div>
            <input id="user_name" type="text" name="user_name" value="{{ $user->user_name }}" required autocomplete="user_name" >

            @error('user_name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <label for="user_email" >{{ __('メールアドレス') }}</label>

        <div>
            <input id="user_email" type="email" name="user_email" value="{{ $user->user_email }}" required autocomplete="user_email">

            @error('user_email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <label for="user_birthday" >{{ __('生年月日') }}</label>

        <div>
            <input id="user_birthday" type="date" name="user_birthday" value="{{ $user->user_birthday }}" required autocomplete="user_birthday" >

            @error('user_birthday')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <label for="user_gender" >{{ __('性別') }}</label>

        <div>
            @foreach(Consts::GENDER_LIST as $key => $value)
                <input id="user_gender_{{$key}}" type="radio"  value="{{ $key }}"  name="user_gender" @if ($user->user_gender == $key) {{"checked"}} @endif>
                <label for="user_gender_{{$key}}" class="form-check-label">{{ $value }}</label>
            @endforeach

            @error('user_gender')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <a href="{{route('admin.user.index')}}">戻る</a>
        <input type="submit" value="更新">
    </form>

</div>
@endsection