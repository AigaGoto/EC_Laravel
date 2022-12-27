@extends('layouts.app')

@section('content')
<div>
    <div>
        <img src="{{$product->product_image_file}}" alt="{{$product->product_image_file}}" width="100">
        <p>{{ $product->product_name }}</p>
    </div>
    <div>
        <p>レビュー(合計{{$product->reviewCounts}}件)</p>
        @foreach($reviews as $review)
            @include('layouts.userIcon', ['user_icon_image'=>$review->user->user_icon_image])
            <p>{{$review->user->user_name}}</p>
            <p>{{ $review->updated_at->format('Y/m/d H:i:s') }}</p>
            @foreach($review->tags as $tag)
                <p>{{  $tag->tag_name }}</p>
            @endforeach
            <p>{{ $review->review_content }}</p>
        @endforeach
        {{ $reviews->links() }}

        @if (count($reviews) >0)
            <p>全{{ $reviews->total() }}件中
            {{  ($reviews->currentPage() -1) * $reviews->perPage() + 1}} -
            {{ (($reviews->currentPage() -1) * $reviews->perPage() + 1) + (count($reviews) -1)  }}件のデータが表示されています。</p>
        @else
            <p>データがありません。</p>
        @endif
    </div>
    <a href="{{route('user.product.show', $product->product_id)}}">商品詳細ページはこちら</a>
</div>
@endsection