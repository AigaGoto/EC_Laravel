<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Product;
use App\Model\Rate;
use App\Model\Review;
use App\Services\GetProductService;
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
        $products = Product::with('rates', 'reviews')->paginate(\Consts::PAGINATE_NUM);

        // 商品に紐づいたレビュー数と評価数を取得
        foreach ($products as $key => $value) {
            $products[$key]['highrateCounts'] = $products[$key]->rates->where('rate_type', '=', \Consts::RATE_HIGH)->count();
            $products[$key]['lowrateCounts'] = $products[$key]->rates->where('rate_type', '=', \Consts::RATE_LOW)->count();
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
    public function show($product_id, GetProductService $getProductService)
    {
        $product = $getProductService->getProduct($product_id);

        // レビュー部分を3件取得
        $reviews = $product->reviews->take(3);

        // 認証中のユーザーが評価しているかを取得
        $rate = Rate::where('product_id', $product_id)->where('user_id', Auth::id())->first();

        // 認証中のユーザーがレビューしているかを取得
        $login_user_review = Review::where('product_id', $product_id)->where('user_id', Auth::id())->first();

        return view('user.product.show', compact('product', 'reviews', 'rate', 'login_user_review'));
    }

}
