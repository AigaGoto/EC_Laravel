@extends('layouts.app')

@section('content')
<div>
    <img src="{{$product->product_image_file}}" alt="{{$product->product_image_file}}" width="100">
    <p>{{ $product->product_name }}</p>
    <p>¥{{ $product->product_price }}</p>
    <p>高評価</p>
    @if($rate)
        {{-- <a href="{{ route('rate.destroy', $product->product_id, 1)}}">
            <iconify-icon icon="icon-park-solid:good-two"></iconify-icon>
        </a> --}}
    @else
        <form method="POST" action="{{ route('rate.store', ['product_id' =>$product->product_id]) }}">
        @csrf
            <input type="hidden" name="product_id" value="{{$product->product_id}}">
            <input type="hidden" name="rate_type" value="1">
            <button type="submit">
                <iconify-icon icon="icon-park-solid:good-two"></iconify-icon>
            </button>
        </form>
    @endif
    <p>{{ $rate }}</p>
    <p>{{ $product->highrateCounts }}</p>
    <p>低評価</p>
    <iconify-icon icon="icon-park-solid:bad-two"></iconify-icon>
    <p>{{ $product->lowrateCounts }}</p>
    <input type="number">
    <button>購入</button>
    <p>この商品について</p>
    <p>{{ $product->product_description }}</p>
</div>
<div>-------------------</div>
<div>
    <p>レビュー(合計{{$product->reviewCounts}}件)</p>
    @foreach($reviews as $review) 
        <img src="{{$review->user->user_icon_image}}" alt="{{$review->user->user_icon_image}}" width="100">
        <p>{{$review->user->user_name}}</p>
        <p>{{ $review->review_content }}</p>
    @endforeach
</div>
<div>
    <a href="{{ url('/') }}">全てのレビューを参照</a>
    <a href="{{ url('/') }}">レビューを書く</a>
</div>
@endsection

<script>
    function good(product_id) {
        $.ajax({
            headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            url: `/user/product/${product_id}/rate/store`,
            type: "POST",
        })
        .done(function (data, status, xhr) {
        console.log(data);
        })
        .fail(function (xhr, status, error) {
        console.log();
        });
    }
</script>