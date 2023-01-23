<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Model\Review;
use App\Services\CreateLogService;

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

        // レビューのキーワードが検索されているなら絞り込む
        $reviews = Review::with('user', 'product')->when($keyword, function ($query, $keyword) {
            return $query->where('review_content', 'LIKE', "%{$keyword}%");
        })
        ->latest()
        ->paginate(\Consts::PAGINATE_NUM);

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
    public function destroy(Request $request,$review_id, CreateLogService $createLogService)
    {
        $review = Review::find($review_id);

        DB::beginTransaction();
        try {
            $review->delete();

            // ログの作成
            $createLogService->createLog(\Consts::LOG_DELETE, \Consts::TABLE_REVIEW, Auth::id(), $request);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }


        return redirect()->route('admin.review.index');
    }
}
