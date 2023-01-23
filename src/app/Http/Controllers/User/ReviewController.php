<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\User;
use App\Model\Review;
use App\Model\Tag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Services\CreateLogService;
use App\Rules\CustomDistinctArrayValidation;

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
    public function index()
    {
        // 認証中のユーザーのレビューを取得
        $reviews = Review::with('tags', 'product')->where('user_id', Auth::id())->latest()->paginate(\Consts::PAGINATE_NUM);

        foreach ($reviews as $key=>$review) {
            $diff_hours = now()->diffInHours($review->created_at);
            if($diff_hours <= 12) {
                $reviews[$key]['canEdit']= true;
            }
        }
        return view('user.review.index', compact('reviews'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($review_id, Request $request)
    {
        $review = Review::with('product', 'tags')->findOrFail($review_id);
        if (now()->diffInHours($review->created_at) > 12) {
            abort(404);
        }
        $product = $review->product;
        $tags = $review->tags;

        // 確認画面で戻るボタンを押した時
        if (old('back')) {
            $tags = null;
        };
        return view('user.review.edit', compact('review', 'product', 'tags'));
    }

    public function update($review_id, Request $request, CreateLogService $createLogService)
    {
        // 戻るボタンが押されたら、編集画面に戻す
        if ($request->input('back') == '戻る') {
            return redirect()
                ->route('user.review.edit', ['review' => $review_id])
                ->withInput();
        };

        $validatedData = $request->validate([
            'tags' => 'array',
            'tags.*' => 'max:100',
            'review_content' => 'required',
        ]);

        $review = Review::with('tags')->find($review_id);

        DB::beginTransaction();
        try {
            // レビューの更新
            $review->review_content = $request->review_content;
            $review->save();
            // 前のタグをレビューから外す
            if ($review->tags != null) {
                foreach($review->tags as $tag) {
                    $tag->reviews()->detach($review->review_id);
                }
            }

            // 新しいタグをレビューにつける
            if ($request->tags != null) {
                foreach ($request->tags as $tag_name) {
                    $tag = Tag::firstOrCreate([
                        'tag_name' => $tag_name
                    ]);

                    $tag->reviews()->attach($review->review_id);
                };
            }

            // ログの作成
            $createLogService->createLog(\Consts::LOG_UPDATE, \Consts::TABLE_REVIEW, Auth::id(), $request);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }

        return redirect()->route('user.review.index');
    }

    public function confirm($review_id, Request $request)
    {
        $validatedData = $request->validate([
            'tags' => ['array', new CustomDistinctArrayValidation],
            'tags.*' => 'max:100',
            'review_content' => 'required',
        ]);

        $review = Review::with('product')->findOrFail($review_id);

        $product = $review->product;
        $review_content = $request->review_content;
        $tags = $request->tags;

        return view('user.review.confirm', compact('review', 'product', 'review_content', 'tags'));
    }

}
