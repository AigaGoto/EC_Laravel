@extends('layouts.adminApp')

@section('content')
@include('layouts.adminSidebar')
<div class="admin-main-container">
    <h1>管理者の新規登録</h1>

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

    <form  method="POST" action="{{ route('admin.admin.store') }}">
        @csrf
        <div>
            <label for="admin_email">メールアドレス</label>
            <input type="email" name="admin_email" value="{{ old('admin_email') }}">
        </div>

        <div>
            <label for="admin_password">パスワード</label>
            <input type="password" name="admin_password" value="{{ old('admin_password') }}">
        </div>

        <div>
            <label for="admin_password_confirmation">パスワード確認用</label>
            <input type="password" name="admin_password_confirmation" value="{{ old('admin_password') }}">
        </div>

        <div>
            <label for="admin_name">管理者名</label>
            <input type="text" name="admin_name" value="{{ old('admin_name') }}">
        </div>

        <button>キャンセル</button>
        <input type="submit" value="登録">
    </form>

</div>
@endsection