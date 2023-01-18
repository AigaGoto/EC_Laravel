@extends('layouts.adminApp')

@section('content')
@include('layouts.adminSidebar')
<div class="admin-main-container">
    <h1>管理者画面</h1>

    <div class="admin-content-wrapper">
        <p>最新のレビュー</p>
        <table class="admin-table">
            <tr>
                <th>レビューID</th>
                <th>ユーザーID</th>
                <th>ユーザー名</th>
                <th>商品ID</th>
                <th>商品名</th>
                <th>レビュー内容</th>
                <th>投稿日</th>
            </tr>

            @foreach($reviews as $review)
            <tr>
                <td>{{ $review->review_id }}</td>
                <td>{{ $review->user_id }}</td>
                <td>{{ $review->user_name }}</td>
                <td>{{ $review->product_id }}</td>
                <td>{{ $review->product_name }}</td>
                <td class="admin-table-long">{{ $review->review_content }}</td>
                <td>{{ $review->created_at }}</td>
            </tr>
            @endforeach
        </table>
    </div>
    <div class="after-content">
        <a class="white-button right-button" href="{{ route('admin.review.index') }}">レビュー一覧はこちら</a>
    </div>
</div>
@endsection
