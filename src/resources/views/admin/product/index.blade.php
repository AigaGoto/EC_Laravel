@extends('layouts.adminApp')

@section('content')
@include('layouts.adminSidebar')
<div class="admin-main-container">
    <h1>商品一覧</h1>

    <div class="admin-content-wrapper">

        <div class="admin-table-search">
            <form method="GET" action="{{ route('admin.product.index') }}">
                @csrf
                <p>商品名で検索</p>
                <input type="search" name="product_name" value="@if(isset($product_name)){{ $product_name }}@endif">
                <button type="submit"><iconify-icon icon="ic:baseline-search"></iconify-icon></button>
            </form>
        </div>
        <div>
            <table class="admin-table">
                <tr>
                    <th>商品ID</th>
                    <th>商品名</th>
                    <th>値段</th>
                    <th>商品説明</th>
                    <th>登録日</th>
                    <th>レビュー数</th>
                    <th>高評価数</th>
                    <th>低評価数</th>
                    <th></th>
                </tr>

                @foreach($products as $product)
                <tr>
                    <td>{{ $product->product_id }}</td>
                    <td>{{ $product->product_name }}</td>
                    <td>{{ $product->product_price }}</td>
                    <td class="admin-table-long">{{ $product->product_description }}</td>
                    <td>{{ $product->created_at }}</td>
                    <td>{{ $product->review_count }}</td>
                    <td>{{ $product->highrate_count }}</td>
                    <td>{{ $product->lowrate_count }}</td>
                    <td><a class="gray-button" href="{{route('admin.product.edit', $product->product_id)}}">編集</a></td>
                </tr>
                @endforeach
            </table>

        {{ $products->appends(['product_name' => $product_name ?? ''])->links() }}

        @if (count($products) >0)
        <p>全{{ $products->total() }}件中
            {{  ($products->currentPage() -1) * $products->perPage() + 1}} -
            {{ (($products->currentPage() -1) * $products->perPage() + 1) + (count($products) -1)  }}件のデータが表示されています。</p>
            @else
            <p>データがありません。</p>
            @endif
        </div>
    </div>
</div>
@endsection