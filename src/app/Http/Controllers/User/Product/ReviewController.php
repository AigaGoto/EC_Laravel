<?php

namespace App\Http\Controllers\User\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Product;
use App\Model\Rate;
use App\Model\Review;
use App\Model\Tag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Services\CreateLogService;
use App\Services\GetProductService;

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
        // 商品がない場合には404を表示させる
        $product = Product::with('reviews')->findOrFail($product_id);

        // 商品に紐づいたレビュー数を取得
        $product['reviewCounts'] = $product->reviews->count();

        // レビュー部分
        $reviews = Review::with('tags', 'user')->where('product_id', $product_id)->paginate(\Consts::PAGINATE_NUM);

        return view('user.product.review.index', compact('product', 'reviews'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     *
     */
    public function create($product_id, GetProductService $getProductService)
    {
        // 認証中のユーザーがレビューしているかを取得
        $login_user_review = Review::where('product_id', $product_id)->where('user_id', Auth::id())->first();
        if($login_user_review) {
            // $error = "同じ商品には、1つしかレビューができません";
            // dd(\Lang::get("messages"));
            return redirect()->route('user.product.show', $product_id)
                    ->with(\Lang::get("messages"));
        }

        $product = $getProductService->getProduct($product_id);

        // 認証中のユーザーが評価しているかを取得
        $rate = Rate::where('product_id', $product_id)->where('user_id', Auth::id())->first();

        return view('user.product.review.create', compact('product','rate'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($product_id, Request $request, CreateLogService $createLogService)
    {
        if ($request->input('back') == '戻る') {
            return redirect()
                ->route('user.product.review.create', ['product_id' => $product_id])
                ->withInput();
        };

        $validatedData = $request->validate([
            'tags' => 'array',
            'tags.*' => 'max:100',
            'review_content' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $review = Review::create([
                'review_content' => $request->review_content,
                'product_id' => $product_id,
                'user_id' => Auth::id(),
            ]);

            if ($request->tags != null) {
                foreach ($request->tags as $tag_name) {
                    $tag = Tag::firstOrCreate([
                        'tag_name' => $tag_name
                    ]);

                    $tag->reviews()->attach($review->review_id);
                };
            }

            // ログの作成
            $createLogService->createLog(\Consts::LOG_REGISTER, \Consts::TABLE_REVIEW, Auth::id(), $request);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }

        return redirect()->route('user.product.review.index', ['product_id' => $product_id]);
    }

    public function confirm($product_id, Request $request)
    {
        $validatedData = $request->validate([
            'tags' => 'array',
            'tags.*' => 'max:100|distinct',
            'review_content' => 'required',
        ]);

        $product = Product::with('rates')->findOrFail($product_id);
        $review_content = $request->review_content;
        $tags = $request->tags;

        return view('user.product.review.confirm', compact('product', 'review_content', 'tags'));
    }
}
