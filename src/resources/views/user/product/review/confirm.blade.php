@extends('layouts.app')

@section('content')
<div>
    <h1>この商品をレビュー</h1>
    <img src="{{$product->product_image_file}}" alt="{{$product->product_image_file}}" width="100">
    <p>{{ $product->product_name }}</p>

    <p>------------------------</p>

    <h1>プレビュー</h1>
    <img src="{{asset('storage/sample/' . Auth::user()->user_icon_image)}}" alt="{{Auth::user()->user_icon_image}}" width="100">
    <p>{{ Auth::user()->user_name }}</p>
    <p>時間をここに入れる</p>
    @foreach ($tags as $tag)
        <p>{{$tag}}</p>
    @endforeach
    <p>{{ $review_content }}</p>

    <p>---------------------</p>
    <a href="{{url('/')}}">キャンセル</a>
    <form method="POST" action="{{ route('review.store', $product->product_id) }}">
        @csrf
        <input type="hidden" name="review_content" value="{{ $review_content }}">
        @foreach ($tags as $key => $tag) 
            <input type="hidden" name="tags[{{ $key }}]" value="{{ $tag }}">
        @endforeach
        <input type="submit" value="レビューを投稿">
    </form>
</div>
@endsection