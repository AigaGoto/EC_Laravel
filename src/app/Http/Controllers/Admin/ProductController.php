<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $product_name = $request->input('product_name');

        $query = Product::query();

        // 商品名が入力されているなら、検索する
        if (!empty($product_name)) {
            $query->where('product_name', 'LIKE', "%{$product_name}%");
        }

        $products = $query->paginate(5);

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

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($product_id)
    {
        $product = Product::findOrFail($product_id);
        $product->delete();
        return redirect()->route('admin.product.index');
    }
}
