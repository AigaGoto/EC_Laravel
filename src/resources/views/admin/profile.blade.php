@extends('layouts.adminApp')

@section('content')
@include('layouts.adminSidebar')
<div>
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

    <form method="POST" action="{{ route('admin.profile.update', Auth::user()->admin_id) }}">
        @csrf
        <input type="hidden" name="_method" value="PUT">

        <label for="admin_name" >{{ __('管理者名') }}</label>

        <div>
            <input id="admin_name" type="text" name="admin_name" value="{{ Auth::user()->admin_name }}" required autocomplete="admin_name" >

            @error('admin_name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <label for="admin_email" >{{ __('メールアドレス') }}</label>

        <div>
            <input id="admin_email" type="email" name="admin_email" value="{{ Auth::user()->admin_email }}" required autocomplete="admin_email">

            @error('admin_email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <input type="submit" value="更新">
    </form>

</div>
@endsection
