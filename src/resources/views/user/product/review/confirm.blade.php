@extends('layouts.app')

@section('content')
<div class="main-container">
    <h1>この商品をレビュー</h1>

    <div class="product-top">
        <img src="{{$product->product_image_file}}" alt="{{$product->product_image_file}}">
        <p>{{ $product->product_name }}</p>
    </div>

    <p>------------------------</p>

    <form method="POST" action="{{ route('user.product.review.store', $product->product_id) }}">
        @csrf
        <h1>プレビュー</h1>
        @include('layouts.userIcon', ['user_icon_image'=>Auth::user()->user_icon_image])
        <p>{{ Auth::user()->user_name }}</p>
        <p>{{ now()->format('Y/m/d H:i:s') }}</p>
        @if ($tags != null)
            @foreach ($tags as $key => $tag)
                <p>{{$tag}}</p>
                <input type="hidden" name="tags[{{ $key }}]" value="{{ $tag }}">
            @endforeach
        @endif
        <p>{{ $review_content }}</p>
        <input type="hidden" name="review_content" value="{{ $review_content }}">

    <p>---------------------</p>
        <div class="after-content">
            <input class="white-button left-button" type="submit" name='back' value='戻る'>
            <input class="gray-button" type="submit" value="レビューを投稿">
        </div>
    </form>
</div>
@endsection