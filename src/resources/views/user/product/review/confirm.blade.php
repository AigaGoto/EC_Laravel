@extends('layouts.app')

@section('content')
<div>
    <h1>この商品をレビュー</h1>
    <img src="{{$product->product_image_file}}" alt="{{$product->product_image_file}}" width="100">
    <p>{{ $product->product_name }}</p>

    <p>------------------------</p>
    
    <form method="POST" action="{{ route('review.store', $product->product_id) }}">
        @csrf
        <h1>プレビュー</h1>
        <img src="{{asset('storage/sample/' . Auth::user()->user_icon_image)}}" alt="{{Auth::user()->user_icon_image}}" width="100">
        <p>{{ Auth::user()->user_name }}</p>
        <p>{{ $now }}</p>
        @if ($tags != null)
            @foreach ($tags as $key => $tag)
                <p>{{$tag}}</p>
                <input type="hidden" name="tags[{{ $key }}]" value="{{ $tag }}">
            @endforeach
        @endif
        <p>{{ $review_content }}</p>
        <input type="hidden" name="review_content" value="{{ $review_content }}">

    <p>---------------------</p>

        <input type="submit" name='back' value='戻る'>
        <input type="submit" value="レビューを投稿">
    </form>
</div>
@endsection