@extends('layouts.adminApp')

@section('content')
@include('layouts.adminSidebar')
<div>
    <h1>商品情報の編集</h1>

    <form method="POST" action="{{ route('admin.product.update', $product->product_id) }}" enctype="multipart/form-data">
        @csrf
        
        <input type="hidden" name="_method" value="PUT">

        <label for="product_image_file" >{{ __('商品画像') }}</label>
        <img src="{{$product->product_image_file}}" alt="{{$product->product_image_file}}" width="100">
        <div>
            <input id="product_image_file" type="file" name="product_image_file" value="{{ $product->product_image_file }}">

            @error('product_image_file')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <label for="product_name" >{{ __('商品名') }}</label>

        <div>
            <input id="product_name" type="text" name="product_name" value="{{ $product->product_name }}" required autocomplete="product_name" >

            @error('product_name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <label for="product_price" >{{ __('値段') }}</label>

        <div>
            <input id="product_price" type="price" name="product_price" value="{{ $product->product_price }}" required autocomplete="product_price">

            @error('product_price')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <label for="product_description" >{{ __('商品説明') }}</label>

        <div>
            <input id="product_description" type="text" name="product_description" value="{{ $product->product_description }}" required autocomplete="product_description" >

            @error('product_description')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <a href="{{route('admin.product.index')}}">戻る</a>
        <input type="submit" value="更新">
    </form>

    <form method="POST" action="{{route('admin.product.destroy', $product->product_id)}}">
        @csrf
        <input type="hidden" name="_method" value="DELETE">
        <input type="submit" value="この商品を削除する">
    </form>
    
</div>
@endsection