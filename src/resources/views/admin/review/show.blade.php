@extends('layouts.adminApp')

@section('content')
@include('layouts.adminSidebar')
<div class="admin-main-container">
    <h1>レビュー詳細</h1>

    <div class="admin-content-wrapper">
        <div class="product-top">
            <img src="{{$product->product_image_file}}" alt="{{$product->product_image_file}}" width="100">
            <p>{{ $product->product_name }}</p>
        </div>

        @include('layouts.review')

        <div class="after-content">
            <button class="white-button left-button" onClick="history.back();">戻る</button>
            <form method="POST" action="{{ route('admin.review.destroy', $review->review_id) }}">
                @csrf
                <input type="hidden" name="_method" value="DELETE">
                <input class="red-button" type="submit" name="delete" value="削除" onClick="delete_alert(event); return false;">
            </form>
        </div>
    </div>
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