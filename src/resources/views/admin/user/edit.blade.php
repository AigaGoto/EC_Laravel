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

    {{-- 更新成功の表示 --}}
    @if (session('update_success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('update_success') }}
        </div>
    @endif

    <form class="admin-profile-edit-wrapper" method="POST" action="{{ route('admin.user.update', $user->user_id) }}" enctype="multipart/form-data">
        @csrf

        <input type="hidden" name="_method" value="PUT">

        <div class="profile-item">
            @include('layouts.croppie')
            <label for="user_icon_image" >{{ __('アイコン画像') }}</label>
            <div class="profile-preview-block">
                <div class="profile-user-icon">
                    @include('layouts.userIcon', ['user_icon_image'=>$user->user_icon_image])
                    <label class="white-button edit-user-icon-button">
                        <input class="image" type="file" onchange="previewImage(this);">
                        <iconify-icon icon="akar-icons:pencil" /></iconify-icon>
                        編集
                    </label>
                </div>
                <div class="profile-user-icon-preview" id="preview-display" style="display: none">
                    <iconify-icon icon="material-symbols:double-arrow"></iconify-icon>
                    <img id="image-output" class="">
                </div>
            </div>

            <input type="hidden" name="user_icon_image" id="user_icon_image" value="">

            @error('user_icon_image')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="profile-item">
            <label for="user_name" >{{ __('名前') }}</label>
            <input class="profile-input" id="user_name" type="text" name="user_name" value="{{ $user->user_name }}" required autocomplete="user_name" >

            @error('user_name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="profile-item">
            <label for="user_email" >{{ __('メールアドレス') }}</label>
            <input class="profile-input" id="user_email" type="email" name="user_email" value="{{ $user->user_email }}" required autocomplete="user_email">

            @error('user_email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="profile-item">
            <label for="user_birthday" >{{ __('生年月日') }}</label>
            <input class="profile-input" id="user_birthday" type="date" name="user_birthday" value="{{ $user->user_birthday }}" required autocomplete="user_birthday" >

            @error('user_birthday')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="profile-item">
            <label for="user_gender" >{{ __('性別') }}</label>
            <div class="profile-gender-radio-button">
                @foreach(Consts::GENDER_LIST as $key => $value)
                <div>
                    <input id="user_gender_{{$key}}" type="radio"  value="{{ $key }}"  name="user_gender" @if ($user->user_gender == $key) {{"checked"}} @endif>
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

        <div class="after-content">
            <a class="white-button left-button" href="{{route('admin.user.index')}}">戻る</a>
            <input class="gray-button" type="submit" value="更新">
        </div>

    </form>

</div>
@endsection

<script>
    function previewImage(obj)
    {
        document.getElementById('preview-display').style = "";
    }
</script>