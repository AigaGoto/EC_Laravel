@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('新規登録') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('user.register') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">
                            <label for="user_email" class="col-md-4 col-form-label text-md-right">{{ __('メールアドレス') }}</label>

                            <div class="col-md-6">
                                <input id="user_email" type="email" class="form-control @error('user_email') is-invalid @enderror" name="user_email" value="{{ old('user_email') }}" required autocomplete="user_email" autofocus>

                                @error('user_email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="user_password" class="col-md-4 col-form-label text-md-right">{{ __('パスワード') }}</label>

                            <div class="col-md-6">
                                <input id="user_password" type="password" class="form-control @error('user_password') is-invalid @enderror" name="user_password" required autocomplete="new-user_password">

                                @error('user_password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="user_password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('パスワード(確認用)') }}</label>

                            <div class="col-md-6">
                                <input id="user_password-confirm" type="password" class="form-control" name="user_password_confirmation" required autocomplete="new-user_password">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="user_name" class="col-md-4 col-form-label text-md-right">{{ __('名前') }}</label>

                            <div class="col-md-6">
                                <input id="user_name" type="text" class="form-control @error('user_name') is-invalid @enderror" name="user_name" value="{{ old('user_name') }}" required autocomplete="user_name" >

                                @error('user_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="user_birthday" class="col-md-4 col-form-label text-md-right">{{ __('生年月日') }}</label>

                            <div class="col-md-6">
                                <input id="user_birthday" type="date" class="form-control @error('user_birthday') is-invalid @enderror" name="user_birthday" value="{{ old('user_birthday') }}" required autocomplete="user_birthday" >

                                @error('user_birthday')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="user_gender" class="col-md-4 col-form-label text-md-right">{{ __('性別') }}</label>

                            <div class="col-md-6">
                                @foreach(Consts::GENDER_LIST as $key => $value)
                                    <input id="user_gender_{{$key}}" type="radio" class=" @error('user_gender') is-invalid @enderror"  value="{{ $key }}"  name="user_gender" {{ old ('release') == Consts::GENDER_MALE ? 'checked' : '' }} @if ($key == Consts::GENDER_MALE) {{"checked"}} @endif>
                                    <label for="user_gender_{{$key}}" class="form-check-label">{{$value}}</label>
                                @endforeach

                                @error('user_gender')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            @include('layouts.croppie')
                            <label for="user_icon_image" class="col-md-4 col-form-label text-md-right">{{ __('アイコン画像') }}</label>

                            <div class="col-md-6">
                                <label class="white-button edit-user-icon-button">
                                    <input class="image" type="file" onchange="previewImage(this);">
                                    ファイルを選択
                                </label>

                                <div class="profile-user-icon-preview" id="preview-display" style="display: none">
                                    <img id="image-output" class="">
                                </div>

                                <input type="hidden" name="user_icon_image" id="user_icon_image" value="11">

                                @error('user_icon_image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('新規登録') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<script>
    function previewImage(obj)
    {
        document.getElementById('preview-display').style = "";
    }
</script>