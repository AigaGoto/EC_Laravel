@extends('layouts.app')

@section('content')
<div class="main-container">
    <div class="product-top">
        <img src="{{$product->product_image_file}}" alt="{{$product->product_image_file}}" width="100">
        <p>{{ $product->product_name }}</p>
    </div>
    <div class="reviews">
        <p class="review-total">レビュー(合計{{$product->reviewCounts}}件)</p>
        @foreach($reviews as $review)
            @include('layouts.review')
        @endforeach
    </div>
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

    <div class="after-content">
        <a class="white-button" href="{{route('user.product.show', $product->product_id)}}">商品詳細ページはこちら</a>
    </div>
</div>
@endsection