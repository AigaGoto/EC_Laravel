@extends('layouts.app')

@section('content')
<div class="main-side-container">
    @include('layouts.userSidebar')
    <div class="main-container">
        <h1>ユーザー情報</h1>

        {{-- 更新成功の表示 --}}
        @if (session('update_success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('update_success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('user.profileUpdate') }}" enctype="multipart/form-data">
            @csrf

            <input type="hidden" name="_method" value="PUT">

            <div class="profile-item">
                <label for="user_icon_image" >{{ __('アイコン画像') }}</label>
                <div class="profile-preview-block">
                    <div class="profile-user-icon">
                        @include('layouts.userIcon', ['user_icon_image'=>Auth::user()->user_icon_image])
                        <label class="white-button edit-user-icon-button">
                            <input id="user_icon_image" type="file" name="user_icon_image" value="{{ Auth::user()->user_icon_image }}" onchange="previewImage(this);">
                            <iconify-icon icon="akar-icons:pencil" /></iconify-icon>
                            編集
                        </label>
                    </div>
                    <div class="profile-user-icon-preview" id="preview-display" style="display: none">
                        <iconify-icon icon="material-symbols:double-arrow"></iconify-icon>
                        <img id="preview" class="">
                    </div>
                </div>

                @error('user_icon_image')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="profile-item">
                <label for="user_name" >{{ __('ユーザー名') }}</label>
                <input class="profile-input" id="user_name" type="text" name="user_name" value="{{ Auth::user()->user_name }}" required autocomplete="user_name" >

                @error('user_name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="profile-item">
                <label for="user_email" >{{ __('メールアドレス') }}</label>
                <input class="profile-input" id="user_email" type="email" name="user_email" value="{{ Auth::user()->user_email }}" required autocomplete="user_email">

                @error('user_email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="profile-item">
                <label for="user_birthday" >{{ __('生年月日') }}</label>
                <input class="profile-input" id="user_birthday" type="date" name="user_birthday" value="{{ Auth::user()->user_birthday }}" required autocomplete="user_birthday" >

                @error('user_birthday')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div  class="profile-item">
                <label for="user_gender" >{{ __('性別') }}</label>
                <div class="profile-gender-radio-button">
                    @foreach(Consts::GENDER_LIST as $key => $value)
                    <div>
                        <input id="user_gender_{{$key}}" type="radio"  value="{{ $key }}"  name="user_gender" @if (Auth::user()->user_gender == $key) {{"checked"}} @endif>
                        <label for="user_gender_{{$key}}" class="form-check-label">{{ $value }}</label>
                    </div>
                    @endforeach
                </div>

                @error('user_gender')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <input class="gray-button" type="submit" value="更新">
        </form>

    </div>
</div>
@endsection

<script>
    function previewImage(obj)
    {
        let fileReader = new FileReader();
        fileReader.onload = (function() {
            document.getElementById('preview').src = fileReader.result;
        });
        fileReader.readAsDataURL(obj.files[0]);

        document.getElementById('preview-display').style = "";
    }
</script>