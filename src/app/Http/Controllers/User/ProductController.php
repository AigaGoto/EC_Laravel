<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Product;
use App\Model\Rate;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::with('rates', 'reviews')->paginate(5);

        // 商品に紐づいたレビュー数と評価数を取得
        foreach ($products as $key => $value) {
            $products[$key]['highrateCounts'] = $products[$key]->rates->where('rate_type', '=', '1')->count();
            $products[$key]['lowrateCounts'] = $products[$key]->rates->where('rate_type', '=', '2')->count();
            $products[$key]['reviewCounts'] = $products[$key]->reviews->count();
        }

        return view('user.product.index', compact('products'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($product_id)
    {
        // 商品がない場合には404を表示させる
        $product = Product::with('rates', 'reviews.user', 'reviews.tags')->findOrFail($product_id);

        // 商品に紐づいたレビュー数と評価数を取得
        $product['highrateCounts'] = $product->rates->where('rate_type', '=', '1')->count();
        $product['lowrateCounts'] = $product->rates->where('rate_type', '=', '2')->count();
        $product['reviewCounts'] = $product->reviews->count();

        // レビュー部分を3件取得
        $reviews = $product->reviews->take(3);

        // 認証中のユーザーが評価しているかを取得
        $rate = Rate::where('product_id', $product_id)->where('user_id', Auth::id())->first();

        return view('user.product.show', compact('product', 'reviews', 'rate'));
    }

}
