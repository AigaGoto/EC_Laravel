<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Model\Review;
use App\Model\Log;

class ReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');

        $query = Review::query();

        // キーワードが入力されているなら、検索する
        if (!empty($keyword)) {
            $query->where('review_content', 'LIKE', "%{$keyword}%");
        }

        $reviews = $query->paginate(5);

        // レビューに基づいたユーザーと商品のデータを紐付ける
        foreach ($reviews as $key => $value) {
            $reviews[$key]['user_id'] = $reviews[$key]->user->user_id;
            $reviews[$key]['user_name'] = $reviews[$key]->user->user_name;
            $reviews[$key]['product_id'] = $reviews[$key]->product->product_id;
            $reviews[$key]['product_name'] = $reviews[$key]->product->product_name;
        }

        return view('admin.review.index', compact('reviews', 'keyword'));
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
    public function destroy(Request $request,$review_id)
    {
        $review = Review::find($review_id);
        $review->delete();

        // ログの作成
        Log::create([
            'log_type' => 3,
            'log_table_type' => 3,
            'log_ip_address' => $request->ip(),
            'log_user_agent' => $request->header('User-Agent'),
            'user_id' => Auth::id(),
            'log_path' => $request->path(),
        ]);

        return redirect()->route('admin.review.index');
    }
}
