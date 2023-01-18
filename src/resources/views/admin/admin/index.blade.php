@extends('layouts.adminApp')

@section('content')
@include('layouts.adminSidebar')
<div class="admin-main-container">
    <h1>管理者一覧</h1>

    <a class="to-admin-register" href="{{ route('admin.admin.create') }}">管理者の新規登録はこちら</a>

    <div class="admin-content-wrapper">

        <div class="admin-table-search">
            <form method="GET" action="{{ route('admin.admin.index') }}">
                @csrf
                <p>名前で検索</p>
                <input type="search" name="admin_name" value="@if(isset($admin_name)){{ $admin_name }}@endif">
                <button type="submit"><iconify-icon icon="ic:baseline-search"></iconify-icon></button>
            </form>
        </div>
        <div>
            <table class="admin-table">
                <tr>
                    <th>管理者名</th>
                    <th>メールアドレス</th>
                    <th>登録日</th>
                </tr>

                @foreach($admins as $admin)
                <tr>
                    <td>{{ $admin->admin_name }}</td>
                    <td>{{ $admin->admin_email }}</td>
                    <td>{{ $admin->created_at }}</td>
                </tr>
                @endforeach
            </table>

        {{ $admins->appends(['admin_name' => $admin_name ?? ''])->links() }}

        @if (count($admins) >0)
        <p>全{{ $admins->total() }}件中
            {{  ($admins->currentPage() -1) * $admins->perPage() + 1}} -
            {{ (($admins->currentPage() -1) * $admins->perPage() + 1) + (count($admins) -1)  }}件のデータが表示されています。</p>
            @else
            <p>データがありません。</p>
            @endif
        </div>
    </div>
</div>
@endsection