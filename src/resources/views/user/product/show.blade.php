@extends('layouts.app')

@section('content')
<div>

    @if (session('error'))
        <div class="alert alert-danger">
            <ul>
                <li>{{ session('error') }}</li>
            </ul>
        </div>
    @endif

    <img src="{{$product->product_image_file}}" alt="{{$product->product_image_file}}" width="100">
    <p>{{ $product->product_name }}</p>
    <p>¥{{ $product->product_price }}</p>

    {{-- 評価ボタン --}}
    @include('layouts.rateButton')

    <input type="number">
    <button>購入</button>
    <p>この商品について</p>
    <p>{{ $product->product_description }}</p>
</div>
<div>-------------------</div>
<div>
    <p>レビュー(合計{{$product->reviewCounts}}件)</p>
    @foreach($reviews as $review)
        <img src="{{asset('storage/sample/' . $review->user->user_icon_image)}}" alt="{{$review->user->user_icon_image}}" width="100">
        <p>{{$review->user->user_name}}</p>
        <p>{{ $review->updated_at->format('Y/m/d H:i:s') }}</p>
        @foreach($review->tags as $tag)
            <p>{{  $tag->tag_name }}</p>
        @endforeach
        <p>{{ $review->review_content }}</p>
    @endforeach
</div>
<div>
    <a href="{{ route('user.product.review.index', $product->product_id) }}">全てのレビューを参照</a>
    @if(empty($login_user_review))
        <a href="{{ route('user.product.review.create', $product->product_id) }}">レビューを書く</a>
    @else
        <p>レビュー投稿済み</p>
    @endif
</div>
@endsection
