@extends('layouts.app')

@section('content')
<div>
    @foreach($products as $product)
        <img src="{{$product->product_image_file}}" alt="{{$product->product_image_file}}" width="100">
        <a href="{{ route('user.product.show', $product->product_id) }}">{{ $product->product_name }}</a>
        <p>¥{{ $product->product_price }}</p>
        <p>高評価</p>
        <p>{{ $product->highrateCounts }}</p>
        <p>低評価</p>
        <p>{{ $product->lowrateCounts }}</p>
        <p>レビュー数</p>
        <p>{{ $product->reviewCounts }}</p>
    @endforeach
    {{ $products->links() }}

    @if (count($products) >0)
        <p>全{{ $products->total() }}件中
        {{  ($products->currentPage() -1) * $products->perPage() + 1}} -
        {{ (($products->currentPage() -1) * $products->perPage() + 1) + (count($products) -1)  }}件のデータが表示されています。</p>
    @else
        <p>データがありません。</p>
    @endif
</div>
@endsection