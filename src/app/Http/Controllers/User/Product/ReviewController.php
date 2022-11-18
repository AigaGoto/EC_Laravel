<?php

namespace App\Http\Controllers\User\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Product;
use App\Model\Rate;
use App\Model\Review;
use App\Model\Tag;
use Illuminate\Support\Facades\Auth;
use Session;

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
        // if(Session::get('_old_input')) {
        //     dd(Session::get('_old_input'));
        // }
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($product_id, Request $request)
    {
        if ($request->input('back') == '戻る') {
            return redirect()
                ->route('review.create', ['product_id' => $product_id])
                ->withInput();
        };

        $validatedData = $request->validate([
            'tags' => 'array',
            'tags.*' => 'max:100',
            'review_content' => 'required',
        ]);

        $review = Review::create([
            'review_content' => $request->review_content,
            'product_id' => $product_id,
            'user_id' => Auth::id(),
        ]);
        
        foreach ($request->tags as $tag_name) {
            $tag = Tag::firstOrCreate([
                'tag_name' => $tag_name
            ]);
            
            $tag->reviews()->attach($review->review_id);
        };

        return redirect()->route('review.index', ['product_id' => $product_id]);
    }

    public function confirm($product_id, Request $request)
    {
        // dd($request->tags);
        $validatedData = $request->validate([
            'tags' => 'array',
            'tags.*' => 'max:100',
            'review_content' => 'required',
        ]);

        $product = Product::with('rates')->findOrFail($product_id);

        $review_content = $request->review_content;

        $tags = $request->tags;
        // タグの削除機能を追加後、エラーが起きそうなので、tagsをforeachで作り直す

        return view('user.product.review.confirm', compact('product', 'review_content', 'tags'));
    }
}
