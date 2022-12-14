<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Model\Review;

class ReviewController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth:admin');
    // }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reviews = Review::with('user', 'product')->paginate(5);

        // レビューに基づいたユーザーと商品のデータを紐付ける
        foreach ($reviews as $key => $value) {
            $reviews[$key]['user_id'] = $reviews[$key]->user->user_id;
            $reviews[$key]['user_name'] = $reviews[$key]->user->user_name;
            $reviews[$key]['product_id'] = $reviews[$key]->product->product_id;
            $reviews[$key]['product_name'] = $reviews[$key]->product->product_name;
        }

        return view('admin.review.index', compact('reviews'));
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($review_id)
    {
        $review = Review::with('user', 'product', 'tags')->findOrFail($review_id);
        $user = $review->user;
        $product = $review->product;
        $tags = $review->tags;

        return view('admin.review.show', compact('review', 'user', 'product', 'tags'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($review_id)
    {
        $review = Review::find($review_id);
        $review->delete();
        return redirect()->route('admin.review.index');
    }
}
