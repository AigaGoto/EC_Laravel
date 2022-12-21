@extends('layouts.adminApp')

@section('content')
@include('layouts.adminSidebar')
<div>
    <h1>ログ一覧</h1>

    <form method="GET" action="{{ route('admin.log') }}" >
        <p>操作名で検索</p>

        <p><input type="checkbox" name="log_type[]" value="1" @if(!empty($log_types) && in_array(1, $log_types)) {{"checked"}} @endif>登録</p>
        <p><input type="checkbox" name="log_type[]" value="2" @if(!empty($log_types) && in_array(2, $log_types)) {{"checked"}} @endif>更新</p>
        <p><input type="checkbox" name="log_type[]" value="3" @if(!empty($log_types) && in_array(3, $log_types)) {{"checked"}} @endif>削除</p>
        <p><input type="checkbox" name="log_type[]" value="4" @if(!empty($log_types) && in_array(4, $log_types)) {{"checked"}} @endif>ログイン</p>
        <p><input type="checkbox" name="log_type[]" value="90" @if(!empty($log_types) && in_array(90, $log_types)) {{"checked"}} @endif>その他</p>

        <button type="submit">
            <iconify-icon icon="ic:baseline-search"></iconify-icon>
            検索
        </button>
    </form>

    <div>
        <table>
            <tr>
                <th>ユーザーID</th>
                <th>IPアドレス</th>
                <th>操作名</th>
                <th>テーブル</th>
                <th>ユーザーエージェント</th>
                <th>ログパス</th>
                <th>実行日</th>
            </tr>
            
            @foreach($logs as $log)
            <tr>
                <td>{{ $log->user_id }}</td>
                <td>{{ $log->log_ip_address }}</td>
                <td>{{ $log->log_type }}</td>
                <td>{{ $log->log_table_type }}</td>
                <td>{{ $log->log_user_agent }}</td>
                <td>{{ $log->log_path }}</td>
                <td>{{ $log->created_at }}</td>
            </tr>
            @endforeach
        </table>

    {{ $logs->appends(['log_type' => $log_types ?? ''])->links() }}
    
    @if (count($logs) >0)
    <p>全{{ $logs->total() }}件中 
        {{  ($logs->currentPage() -1) * $logs->perPage() + 1}} - 
        {{ (($logs->currentPage() -1) * $logs->perPage() + 1) + (count($logs) -1)  }}件のデータが表示されています。</p>
        @else
        <p>データがありません。</p>
        @endif 
    </div>
</div>
@endsection