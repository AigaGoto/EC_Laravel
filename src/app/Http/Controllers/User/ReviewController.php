<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\User;
use App\Model\Review;
use App\Model\Tag;
use App\Model\Log;
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
    public function index()
    {
        $user = User::find(Auth::id());
        $reviews = $user->reviews()->latest()->paginate(5);
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
    public function edit($review_id)
    {
        $review = Review::with('product', 'tags')->findOrFail($review_id);
        if (now()->diffInHours($review->created_at) > 12) {
            abort(404);
        }
        $product = $review->product;
        $tags = $review->tags;
        return view('user.review.edit', compact('review', 'product', 'tags'));
    }
    
    public function update($review_id, Request $request)
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
        Log::create([
            'log_type' => 2,
            'log_table_type' => 3,
            'log_ip_address' => $request->ip(),
            'log_user_agent' => $request->header('User-Agent'),
            'user_id' => Auth::id(),
            'log_path' => $request->path(),
        ]);

        return redirect()->route('user.review.index');
    }

    public function confirm($review_id, Request $request)
    {
        $validatedData = $request->validate([
            'tags' => 'array',
            'tags.*' => 'max:100|distinct',
            'review_content' => 'required',
        ]);

        $review = Review::with('product')->findOrFail($review_id);

        $product = $review->product;
        $review_content = $request->review_content;
        $tags = $request->tags;

        return view('user.review.confirm', compact('review', 'product', 'review_content', 'tags'));
    }

}
