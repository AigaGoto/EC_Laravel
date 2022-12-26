<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Services\CreateLogService;

class ProductController extends Controller
{

    public function __construct(CreateLogService $createLogService)
    {
        $this->middleware('auth:admin');
        $this->createLogService = $createLogService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $product_name = $request->input('product_name');

        // 商品名が検索されているなら絞り込む
        $products = Product::when($product_name, function ($query, $product_name) {
            return $query->where('product_name', 'LIKE', "%{$product_name}%");
        })
        ->paginate(\Consts::PAGINATE_NUM);

        // レビューに基づいたユーザーと商品のデータを紐付ける
        foreach ($products as $key => $value) {
            $products[$key]['review_count'] = $products[$key]->reviews->count();
            $products[$key]['highrate_count'] = $products[$key]->rates->where('rate_type', '=', 1)->count();
            $products[$key]['lowrate_count'] = $products[$key]->rates->where('rate_type', '=', 2)->count();
        }

        return view('admin.product.index', compact('products', 'product_name'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($product_id)
    {
        $product = Product::findOrFail($product_id);

        return view('admin.product.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $product_id)
    {
        $product = Product::findOrFail($product_id);

        $product->update([
            'product_name' => $request->product_name,
            'product_price' => $request->product_price,
            'product_description' => $request->product_description,
        ]);

        // ログの作成
        $this->createLogService->createLog(\Consts::LOG_UPDATE, \Consts::TABLE_PRODUCT, Auth::id(), $request);

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $product_id)
    {
        $product = Product::findOrFail($product_id);
        $product->delete();

        // ログの作成
        $this->createLogService->createLog(\Consts::LOG_DELETE, \Consts::TABLE_PRODUCT, Auth::id(), $request);

        return redirect()->route('admin.product.index');
    }
}
