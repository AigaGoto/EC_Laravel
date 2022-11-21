@extends('layouts.app')

@section('content')
<div>
    <img src="{{$product->product_image_file}}" alt="{{$product->product_image_file}}" width="100">
    <p>{{ $product->product_name }}</p>
    <p>¥{{ $product->product_price }}</p>

    {{-- 高評価部分 --}}
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

    {{-- 低評価部分 --}}
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
        <img src="{{asset('storage/sample/' . $review->user->user_icon_image)}}" alt="{{$review->user->user_icon_image}}" width="100">
        <p>{{$review->user->user_name}}</p>
        <p>{{ $review->updated_at }}</p>
        @foreach($review->tags as $tag)
            <p>{{  $tag->tag_name }}</p>
        @endforeach
        <p>{{ $review->review_content }}</p>
    @endforeach
</div>
<div>
    <a href="{{ route('review.index', $product->product_id) }}">全てのレビューを参照</a>
    <a href="{{ route('review.create', $product->product_id) }}">レビューを書く</a>
</div>
@endsection
