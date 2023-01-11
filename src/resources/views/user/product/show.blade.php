@extends('layouts.app')

@section('content')
<div class="center">

    @if (session('duplicateReviewException'))
    <div class="alert alert-danger">
        <ul>
            <li>{{ session('duplicateReviewException') }}</li>
        </ul>
    </div>
    @endif

    <div class="product-detail">
        <div class="product-detail-top">
            <img src="{{$product->product_image_file}}" alt="{{$product->product_image_file}}" width="100">
            <div class="product-detail-top-right">
                <p>{{ $product->product_name }}</p>
                <p class="product-price">¥{{ $product->product_price }}</p>
            </div>
        </div>

        <div class="product-detail-center">
            {{-- 評価ボタン --}}
            @include('layouts.rateButton')
            <div class="product-purchase">
                <input type="number">
                <button>購入</button>
            </div>
        </div>

        <div class="product-detail-bottom">
            <p class="product-description-title">この商品について</p>
            <p class="product-description-main">{{ $product->product_description }}</p>
        </div>
    </div>
    <div class="border-line"></div>
    <div class="reviews">
        <p class="review-total">レビュー(合計{{$product->reviewCounts}}件)</p>
        @foreach($reviews as $review)
            <div class="review-item">
                <div class="review-item-top">
                    @include('layouts.userIcon', ['user_icon_image'=>$review->user->user_icon_image])
                    <p class="review-user-name">{{$review->user->user_name}}</p>
                    <p class="review-time">{{ $review->updated_at->format('Y/m/d H:i:s') }}</p>
                </div>
                <div class="review-tag-block">
                    @foreach($review->tags as $tag)
                        <p class="review-tag">{{  $tag->tag_name }}</p>
                    @endforeach
                </div>
                <p class="review-content">{{ $review->review_content }}</p>
            </div>
        @endforeach
    </div>
    <div class="after-content">
        <a class="all-review-button" href="{{ route('user.product.review.index', $product->product_id) }}">全てのレビューを参照</a>
        @if(empty($login_user_review))
        <a class="write-review-button" href="{{ route('user.product.review.create', $product->product_id) }}">レビューを書く</a>
        @else
        <p>レビュー投稿済み</p>
        @endif
    </div>
</div>
@endsection