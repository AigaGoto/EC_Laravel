@extends('layouts.app')

@section('content')
<div class="main-side-container">
    @include('layouts.userSidebar')
    <div class="main-container">
        <h1>過去のレビュー</h1>
        @foreach ($reviews as $review)
        <div class="review-item">
            <div class="review-item-top">
                <img src="{{$review->product->product_image_file}}" alt="{{$review->product->product_image_file}}" width="100">
                <p class="review-product-name">{{ $review->product->product_name }}</p>
                <p class="review-time">{{ $review->created_at->format('Y/m/d H:i:s') }}</p>
            </div>
            <div class="review-tag-block">
                @foreach($review->tags as $tag)
                    <p class="tag review-tag">{{  $tag->tag_name }}</p>
                @endforeach
            </div>
            <p class="review-content">{{ $review->review_content }}</p>
            @if ($review->canEdit)
                <a class="review-edit-button" href="{{ route('user.review.edit', $review->review_id) }}">編集</a>
            @endif
        </div>

        @endforeach

        <div class="paginate">
            {{ $reviews->links() }}

            @if (count($reviews) >0)
                <p>全{{ $reviews->total() }}件中
                {{  ($reviews->currentPage() -1) * $reviews->perPage() + 1}} -
                {{ (($reviews->currentPage() -1) * $reviews->perPage() + 1) + (count($reviews) -1)  }}件のデータが表示されています。</p>
            @else
                <p>データがありません。</p>
            @endif
        </div>
    </div>
</div>
@endsection