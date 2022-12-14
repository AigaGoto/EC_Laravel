@extends('layouts.app_admin')

@section('content')
<div>
    <h1>レビュー詳細</h1>
    <img src="{{$product->product_image_file}}" alt="{{$product->product_image_file}}" width="100">
    <p>{{ $product->product_name }}</p>

    <p>------------------------</p>
    
    <img src="{{asset('storage/sample/' . $user->user_icon_image)}}" alt="{{$user->user_icon_image}}" width="100">
    <p>{{ $user->user_name }}</p>
    <p>{{ $review->created_at }}</p>
    @if ($tags != null)
        @foreach ($tags as $key => $tag)
            <p>{{$tag->tag_name}}</p>
        @endforeach
    @endif
    <p>{{ $review->review_content }}</p>

    <p>---------------------</p>

    <button onClick="history.back();">戻る</button>
    <form method="POST" action="{{ route('admin.review.destroy', $review->review_id) }}">
        @csrf
        <input type="hidden" name="_method" value="DELETE">
        <input type="submit" name="delete" value="削除" onClick="delete_alert(event); return false;">
    </form>
</div>

<script>
    function delete_alert(e){
        if(!window.confirm('本当に削除しますか？')){
            return false;
        }
        document.deleteform.submit();
    };
</script>

@endsection