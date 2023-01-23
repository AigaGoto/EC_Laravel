@extends('layouts.adminApp')

@section('content')
@include('layouts.adminSidebar')
<div class="admin-main-container">
    <h1>管理者情報</h1>

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

    <form class="admin-content-wrapper" method="POST" action="{{ route('admin.profile.update', Auth::user()->admin_id) }}">
        @csrf
        <input type="hidden" name="_method" value="PUT">

        <div class="admin-text-input-block">
            <label for="admin_name" >{{ __('管理者名') }}</label>

            <div>
                <input id="admin_name" type="text" name="admin_name" value="{{ Auth::user()->admin_name }}" required autocomplete="admin_name" >

                @error('admin_name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="admin-text-input-block">
            <label for="admin_email" >{{ __('メールアドレス') }}</label>

            <div>
                <input id="admin_email" type="email" name="admin_email" value="{{ Auth::user()->admin_email }}" required autocomplete="admin_email">

                @error('admin_email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <input class="gray-button" type="submit" value="更新">
    </form>

</div>
@endsection
