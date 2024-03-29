@extends('layouts.adminApp')

@section('content')
@include('layouts.adminSidebar')
<div class="admin-main-container">
    <h1>ユーザー一覧</h1>

    <div class="admin-content-wrapper">
        <div class="admin-table-search">
            <form method="GET" action="{{ route('admin.user.index') }}">
                <p>ユーザー名で検索</p>
                <input type="search" name="user_name" value="@if(isset($user_name)){{ $user_name }}@endif">
                <button type="submit"><iconify-icon icon="ic:baseline-search"></iconify-icon></button>
            </form>
        </div>
        <div>
            <table class="admin-table">
                <tr>
                    <th>アイコン画像</th>
                    <th>ユーザーID</th>
                    <th>ユーザー名</th>
                    <th>年齢</th>
                    <th>メールアドレス</th>
                    <th>性別</th>
                    <th>登録日</th>
                    <th>レビューした数</th>
                    <th></th>
                </tr>

                @foreach($users as $user)
                <tr>
                    <td class="admin-table-long">
                        @include('layouts.userIcon', ['user_icon_image'=>$user->user_icon_image])
                    </td>
                    <td>{{ $user->user_id }}</td>
                    <td>{{ $user->user_name }}</td>
                    <td>{{ $user->user_age }}</td>
                    <td>{{ $user->user_email }}</td>
                    <td> @if($user->user_gender==Consts::GENDER_MALE) {{Consts::GENDER_LIST[Consts::GENDER_MALE]}} 
                        @else {{Consts::GENDER_LIST[Consts::GENDER_FEMALE]}} 
                        @endif
                    </td>
                    <td>{{ $user->created_at }}</td>
                    <td>{{ $user->review_count }}</td>
                    <td><a class="gray-button" href="{{route('admin.user.edit', $user->user_id)}}">編集</a></td>
                </tr>
                @endforeach
            </table>

        {{ $users->appends(['user_name' => $user_name ?? ''])->links() }}

        @if (count($users) >0)
        <p>全{{ $users->total() }}件中
            {{  ($users->currentPage() -1) * $users->perPage() + 1}} -
            {{ (($users->currentPage() -1) * $users->perPage() + 1) + (count($users) -1)  }}件のデータが表示されています。</p>
            @else
            <p>データがありません。</p>
            @endif
        </div>
    </div>
</div>
@endsection