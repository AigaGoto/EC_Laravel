@extends('layouts.app')

@section('content')
<div>
    <img src="{{$product->product_image_file}}" alt="{{$product->product_image_file}}" width="100">
    <p>{{ $product->product_name }}</p>
    <p>¥{{ $product->product_price }}</p>
    <p>高評価</p>
    @if($rate)
        @if($rate->rate_type == 1)
        <form method="POST" action="{{ route('rate.destroy', [$product->product_id, $rate->rate_id])}}">
            @csrf
                <input type="hidden" name="_method" value="DELETE">
                <button type="submit">
                    <iconify-icon icon="icon-park-solid:good-two" style="color: #0072BC;"></iconify-icon>
                </button>
            </form>
        @else
        <form method="POST" action="{{ route('rate.update', [$product->product_id, $rate->rate_id])}}">
            @csrf
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="rate_type" value="1">
                <button type="submit">
                    <iconify-icon icon="icon-park-solid:good-two"></iconify-icon>
                </button>
            </form>
        @endif
    @else
        <form method="POST" action="{{ route('rate.store', $product->product_id)}}">
        @csrf
            <input type="hidden" name="rate_type" value="1">
            <button type="submit">
                <iconify-icon icon="icon-park-solid:good-two"></iconify-icon>
            </button>
        </form>
    @endif
    <p>{{ $product->highrateCounts }}</p>
    <p>低評価</p>
    @if($rate)
    @if($rate->rate_type == 2)
    <form method="POST" action="{{ route('rate.destroy', [$product->product_id, $rate->rate_id])}}">
        @csrf
            <input type="hidden" name="_method" value="DELETE">
            <button type="submit">
                <iconify-icon icon="icon-park-solid:bad-two" style="color: #0072BC;"></iconify-icon>
            </button>
        </form>
    @else
    <form method="POST" action="{{ route('rate.update', [$product->product_id, $rate->rate_id])}}">
        @csrf
            <input type="hidden" name="_method" value="PUT">
            <input type="hidden" name="rate_type" value="2">
            <button type="submit">
                <iconify-icon icon="icon-park-solid:bad-two"></iconify-icon>
            </button>
        </form>
    @endif
@else
    <form method="POST" action="{{ route('rate.store', $product->product_id)}}">
    @csrf
        <input type="hidden" name="rate_type" value="2">
        <button type="submit">
            <iconify-icon icon="icon-park-solid:bad-two"></iconify-icon>
        </button>
    </form>
@endif
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