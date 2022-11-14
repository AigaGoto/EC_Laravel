<?php

namespace App\Http\Controllers\User\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Product;
use App\Model\Rate;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
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
    public function index($product_id)
    {
        return view('user.product.review.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($product_id)
    {
        // 商品がない場合には404を表示させる
        $product = Product::with('rates')->findOrFail($product_id);

        // 商品に紐づいたレビュー数と評価数を取得
        $product['highrateCounts'] = $product->rates->where('rate_type', '=', '1')->count();
        $product['lowrateCounts'] = $product->rates->where('rate_type', '=', '2')->count();
        $product['reviewCounts'] = $product->reviews->count();

        // 認証中のユーザーが評価しているかを取得
        $rate = Rate::where('product_id', $product_id)->where('user_id', Auth::id())->first();

        return view('user.product.review.create', compact('product','rate'));
    }

    public function confirm()
    {

    }
}
