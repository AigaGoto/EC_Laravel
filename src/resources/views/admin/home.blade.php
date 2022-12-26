@extends('layouts.adminApp')

@section('content')
@include('layouts.adminSidebar')
<div>
    <h1>管理者画面</h1>
    <p>最新のレビュー</p>

    <div>
        <table>
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
                <td>{{ $review->review_content }}</td>
                <td>{{ $review->created_at }}</td>
            </tr>
            @endforeach
        </table>
    </div>
    <a href="{{ route('admin.review.index') }}">レビュー一覧はこちら</a>
</div>
@endsection
