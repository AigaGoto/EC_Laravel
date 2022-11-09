@extends('layouts.app')

@section('content')
<div>
    <img src="{{$product['product_image_file']}}" alt="{{$product['product_image_file']}}" width="100">
    <p>{{ $product['product_name'] }}</p>
    <p>¥{{ $product['product_price'] }}</p>
    <p>高評価</p>
    <p>{{ $product['highrateCounts'] }}</p>
    <p>低評価</p>
    <p>{{ $product['lowrateCounts'] }}</p>
    <p>この商品について</p>
    <p>{{ $product['product_description'] }}</p>
</div>
<div>-------------------</div>
<div>
    <p>レビュー(合計{{$product['reviewCounts']}}件)</p>
    <p>ここにレビューが並ぶ</p>
    @foreach($reviews as $review) 
        <p>{{ $review['review_content'] }}</p>
    @endforeach
</div>
@endsection