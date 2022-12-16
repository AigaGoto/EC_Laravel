@extends('layouts.adminApp')

@section('content')
@include('layouts.adminSidebar')
<div>
    <h1>レビュー一覧</h1>
    
    <div>
        <form method="GET" action="{{ route('admin.review.index') }}">
            <p>キーワードで検索</p>
            <input type="search" name="keyword" value="@if (isset($keyword)) {{ $keyword }} @endif">
            <button type="submit"><iconify-icon icon="ic:baseline-search"></iconify-icon></button>
        </form>
    </div>
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
                <td><a href="{{route('admin.review.show', $review->review_id)}}">詳細表示</a></td>
            </tr>
            @endforeach
        </table>

    {{ $reviews->appends(['keyword' => $keyword ?? ''])->links() }}
    
    @if (count($reviews) >0)
    <p>全{{ $reviews->total() }}件中 
        {{  ($reviews->currentPage() -1) * $reviews->perPage() + 1}} - 
        {{ (($reviews->currentPage() -1) * $reviews->perPage() + 1) + (count($reviews) -1)  }}件のデータが表示されています。</p>
        @else
        <p>データがありません。</p>
        @endif 
    </div>
</div>
@endsection