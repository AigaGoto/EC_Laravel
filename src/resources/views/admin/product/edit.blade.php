@extends('layouts.adminApp')

@section('content')
@include('layouts.adminSidebar')
<div class="admin-main-container">
    <h1>商品情報の編集</h1>

    {{-- バリデーションエラーの表示 --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="admin-product-edit-wrapper">
        <form method="POST" action="{{ route('admin.product.update', $product->product_id) }}" enctype="multipart/form-data">
            @csrf

            <input type="hidden" name="_method" value="PUT">

            <div class="product-edit-item">
                <label for="product_image_file" >{{ __('商品画像') }}</label>
                <div class="product-icon">
                    <img src="{{$product->product_image_file}}" alt="{{$product->product_image_file}}" width="100">
                    <label class="edit-product-icon-button white-button right-button">
                        <input id="product_image_file" type="file" name="product_image_file" value="{{ $product->product_image_file }}">
                        <iconify-icon icon="akar-icons:pencil" /></iconify-icon>
                        編集
                    </label>
                </div>

                @error('product_image_file')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="product-edit-item">
                <label for="product_name" >{{ __('商品名') }}</label>
                <input class="product-edit-input" id="product_name" type="text" name="product_name" value="{{ $product->product_name }}" required autocomplete="product_name" >

                @error('product_name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="product-edit-item">
                <label for="product_price" >{{ __('値段') }}</label>
                <input class="product-edit-input" id="product_price" type="price" name="product_price" value="{{ $product->product_price }}" required autocomplete="product_price">

                @error('product_price')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="product-edit-item">
                <label for="product_description" >{{ __('商品説明') }}</label>
                <textarea id="product_description" type="text" name="product_description" required autocomplete="product_description" >{{$product->product_description}}</textarea>

                @error('product_description')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="after-content">
                <a class="white-button left-button" href="{{route('admin.product.index')}}">戻る</a>
                <input class="gray-button" type="submit" value="更新">
            </div>
        </form>

        <form method="POST" action="{{route('admin.product.destroy', $product->product_id)}}">
            @csrf
            <input type="hidden" name="_method" value="DELETE">
            <input class="red-button right-button product-delete-button" type="submit" value="この商品を削除する" onClick="delete_alert(event); return false;">
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