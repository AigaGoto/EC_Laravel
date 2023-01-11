@extends('layouts.app')

@section('content')
<div class="center">
    @foreach($products as $product)
        <div class="product-item">
            <img src="{{$product->product_image_file}}" alt="{{$product->product_image_file}}" width="100">
            <div class="product-item-right">
                <a href="{{ route('user.product.show', $product->product_id) }}" class="product-name">{{ $product->product_name }}</a>
                <p class="product-price">¥{{ $product->product_price }}</p>
                <div class="product-item-right-bottom">
                    <span>
                        <iconify-icon icon="icon-park-solid:good-two"></iconify-icon>
                        <span>{{ $product->highrateCounts }}</span>
                    </span>
                    <span>
                        <iconify-icon icon="icon-park-solid:bad-two"></iconify-icon>
                        <span>{{ $product->lowrateCounts }}</span>
                    </span>
                    <span>
                        <span>レビュー数</span>
                        <span>{{ $product->reviewCounts }}</span>
                    </span>
                </div>
            </div>
        </div>
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