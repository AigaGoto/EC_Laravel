<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Review;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reviews = Review::with('user', 'product')->orderBy('created_at', 'DESC')->take(5)->get();

        // レビューに基づいたユーザーと商品のデータを紐付ける
        foreach ($reviews as $key => $value) {
            $reviews[$key]['user_id'] = $reviews[$key]->user->user_id;
            $reviews[$key]['user_name'] = $reviews[$key]->user->user_name;
            $reviews[$key]['product_id'] = $reviews[$key]->product->product_id;
            $reviews[$key]['product_name'] = $reviews[$key]->product->product_name;
        }

        return view('admin.home', compact('reviews'));
    }
}