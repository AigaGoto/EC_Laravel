<?php
namespace App\Services;

use App\Model\Product;

class GetProductService
{
    public function getProduct($product_id)
    {
        // 商品がない場合には404を表示させる
        $product = Product::with('rates', 'reviews.user', 'reviews.tags')->findOrFail($product_id);

        // 商品に紐づいたレビュー数と評価数を取得
        $product['highrateCounts'] = $product->rates->where('rate_type', '=', \Consts::RATE_HIGH)->count();
        $product['lowrateCounts'] = $product->rates->where('rate_type', '=', \Consts::RATE_LOW)->count();
        $product['reviewCounts'] = $product->reviews->count();

        return $product;
    }
}