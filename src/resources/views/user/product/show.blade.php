@extends('layouts.app')

@section('content')
<div class="main-container">

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
    <div class="reviews">
        <p class="review-total">レビュー(合計{{$product->reviewCounts}}件)</p>
        @foreach($reviews as $review)
            @include('layouts.review')
        @endforeach
    </div>
    <div class="after-content">
        <a class="left-button white-button" href="{{ route('user.product.review.index', $product->product_id) }}">全てのレビューを参照</a>
        @if(empty($login_user_review))
            <a class="gray-button" href="{{ route('user.product.review.create', $product->product_id) }}">レビューを書く</a>
        @else
            <p class="after-review">レビュー投稿済み</p>
        @endif
    </div>
</div>
@endsection