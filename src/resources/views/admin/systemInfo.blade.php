@extends('layouts.adminApp')

@section('content')
@include('layouts.adminSidebar')
<div>
    <h1>システム情報</h1>

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

    <form method="POST" action="{{ route('admin.systemInfo.update') }}">
        @csrf
        <input type="hidden" name="_method" value="PUT">

        <label for="error_email">エラー通知先メールアドレス</label>
        <p><input type="error_email" name="error_email" value="{{ $error_email }}"></p>

        <input type="submit" value="更新">
    </form>
</div>
@endsection
