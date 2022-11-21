@extends('layouts.app')

@section('content')
<div>
    <h1>ユーザー情報</h1>
    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
        @csrf

        <label for="user_icon_image" >{{ __('アイコン画像') }}</label>
        <img src="{{asset('storage/sample/' . Auth::user()->user_icon_image)}}" alt="{{Auth::user()->user_icon_image}}" width="100">
        <div>
            <input id="user_icon_image" type="file" >

            @error('user_icon_image')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <label for="user_name" >{{ __('名前') }}</label>

        <div>
            <input id="user_name" type="text" name="user_name" value="{{ Auth::user()->user_name }}" required autocomplete="user_name" >

            @error('user_name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <label for="user_email" >{{ __('メールアドレス') }}</label>

        <div>
            <input id="user_email" type="email" name="user_email" value="{{ Auth::user()->user_email }}" required autocomplete="user_email">

            @error('user_email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <label for="user_birthday" >{{ __('生年月日') }}</label>

        <div>
            <input id="user_birthday" type="date" name="user_birthday" value="{{ Auth::user()->user_birthday }}" required autocomplete="user_birthday" >

            @error('user_birthday')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <label for="user_gender" >{{ __('性別') }}</label>

        <div>
            <input id="user_gender1" type="radio"  value="1"  name="user_gender" checked>
            <label for="user_gender1" class="form-check-label">男</label>
            <input id="user_gender2" type="radio" value="2"  name="user_gender"  >
            <label for="user_gender1" class="form-check-label">女</label>

            @error('user_gender')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
</div>
@endsection