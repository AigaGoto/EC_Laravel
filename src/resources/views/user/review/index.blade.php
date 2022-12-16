@extends('layouts.app')

@section('content')
@include('layouts.userSidebar')
<div>
    <h1>過去のレビュー</h1>
    @foreach ($reviews as $review)
        <img src="{{$review->product->product_image_file}}" alt="{{$review->product->product_image_file}}" width="100">
        <p>{{ $review->product->product_name }}</p>
        <p>{{ $review->created_at->format('Y/m/d H:i:s') }}</p>
        @foreach($review->tags as $tag)
            <p>{{  $tag->tag_name }}</p>
        @endforeach
        <p>{{ $review->review_content }}</p>
        @if ($review->canEdit)
            <p><a href="{{ route('user.review.edit', $review->review_id) }}">編集</a></p>
        @endif
    @endforeach
    {{ $reviews->links() }}

    @if (count($reviews) >0)
        <p>全{{ $reviews->total() }}件中 
        {{  ($reviews->currentPage() -1) * $reviews->perPage() + 1}} - 
        {{ (($reviews->currentPage() -1) * $reviews->perPage() + 1) + (count($reviews) -1)  }}件のデータが表示されています。</p>
    @else
        <p>データがありません。</p>
    @endif 
</div>
@endsection