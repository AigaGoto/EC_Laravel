@extends('layouts.app')

@section('content')
@include('layouts.userSidebar')
<div>
    <h1>購入履歴</h1>

    @foreach ($orders as $order) 
        <img src="{{$order->product->product_image_file}}" alt="{{$order->product->product_image_file}}" width="100">
        <p>{{ $order->product->product_name }}</p>
        <p>注文日:</p>
        <p>{{ $order->created_at->format('Y/m/d') }}</p>
        <p>金額:</p>
        <p>¥{{ $order->product->product_price }}</p>
    @endforeach
    {{ $orders->links() }}

    @if (count($orders) >0)
        <p>全{{ $orders->total() }}件中 
        {{  ($orders->currentPage() -1) * $orders->perPage() + 1}} - 
        {{ (($orders->currentPage() -1) * $orders->perPage() + 1) + (count($orders) -1)  }}件のデータが表示されています。</p>
    @else
        <p>データがありません。</p>
    @endif 
</div>
@endsection