@extends('layouts.app')

@section('content')
<div>
    <h1>この商品をレビュー</h1>
    <img src="{{$product->product_image_file}}" alt="{{$product->product_image_file}}" width="100">
    <p>{{ $product->product_name }}</p>
    
    {{-- 高評価部分 --}}
    @if($rate)
        @if($rate->rate_type == 1)
        <form method="POST" action="{{ route('rate.destroy', [$product->product_id, $rate->rate_id])}}">
            @csrf
                @method('DELETE')
                <button type="submit">
                    <iconify-icon icon="icon-park-solid:good-two" style="color: #0072BC;"></iconify-icon>
                </button>
            </form>
        @else
        <form method="POST" action="{{ route('rate.update', [$product->product_id, $rate->rate_id])}}">
            @csrf
                @method('PUT')
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
                @method('DELETE')
                <button type="submit">
                    <iconify-icon icon="icon-park-solid:bad-two" style="color: #0072BC;"></iconify-icon>
                </button>
            </form>
        @else
        <form method="POST" action="{{ route('rate.update', [$product->product_id, $rate->rate_id])}}">
            @csrf
                @method('PUT')
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

    <p>-----------------------------</p>
    <form action="">
        <h1>タグ</h1>
        <p>タグを入力</p>
        <input type="text" name="tag??">
        <button>タグを追加</button>
        {{-- ここに追加されたタグを表示 --}}

        <p>------------------------------</p>
        <h1>レビュー内容</h1>
        <input type="text" name="review_content">
        <a href="{{url('/')}}">戻る</a>
        <a href="{{url('/')}}">レビューを確認</a>
    </form>
    
</div>
@endsection