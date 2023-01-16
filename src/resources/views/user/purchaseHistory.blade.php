@extends('layouts.app')

@section('content')
<div class="main-side-container">
    @include('layouts.userSidebar')
    <div class="main-container">
        <h1>購入履歴</h1>

        @foreach ($orders as $order)
            <div class="purchase-history-item">
                <div class="purchase-history-item-left">
                    <img class="purchase-history-item-product-img" src="{{$order->product->product_image_file}}" alt="{{$order->product->product_image_file}}" width="100">
                    <p class="purchase-history-item-product-name">{{ $order->product->product_name }}</p>
                </div>
                <div class="purchase-history-item-right">
                    <div>
                        <span>注文日：</span>
                        <span>{{ $order->created_at->format('Y/m/d') }}</span>
                    </div>
                    <div>
                        <span>金額　：</span>
                        <span>¥{{ $order->product->product_price }}</span>
                    </div>
                </div>
            </div>
        @endforeach

        <div class="paginate">
            {{ $orders->links() }}

            @if (count($orders) >0)
                <p>全{{ $orders->total() }}件中
                {{  ($orders->currentPage() -1) * $orders->perPage() + 1}} -
                {{ (($orders->currentPage() -1) * $orders->perPage() + 1) + (count($orders) -1)  }}件のデータが表示されています。</p>
            @else
                <p>データがありません。</p>
            @endif
        </div>
    </div>
</div>
@endsection