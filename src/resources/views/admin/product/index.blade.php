@extends('layouts.adminApp')

@section('content')
@include('layouts.adminSidebar')
<div>
    <h1>商品一覧</h1>
    
    <div>
        <form method="GET" action="{{ route('admin.product.index') }}">
            <p>商品名で検索</p>
            <input type="search" name="product_name" value="@if(isset($product_name)){{ $product_name }}@endif">
            <button type="submit"><iconify-icon icon="ic:baseline-search"></iconify-icon></button>
        </form>
    </div>
    <div>
        <table>
            <tr>
                <th>商品ID</th>
                <th>商品名</th>
                <th>値段</th>
                <th>商品説明</th>
                <th>登録日</th>
                <th>レビュー数</th>
                <th>高評価数</th>
                <th>低評価数</th>
            </tr>
            
            @foreach($products as $product)
            <tr>
                <td>{{ $product->product_id }}</td>
                <td>{{ $product->product_name }}</td>
                <td>{{ $product->product_price }}</td>
                <td>{{ $product->product_description }}</td>
                <td>{{ $product->created_at }}</td>
                <td>{{ $product->review_count }}</td>
                <td>{{ $product->highrate_count }}</td>
                <td>{{ $product->lowrate_count }}</td>
                <td><a href="{{route('admin.product.edit', $product->product_id)}}">編集</a></td>
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
@endsection