<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Model\Product;


class ProductListController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $products = Product::with('rates', 'reviews')->paginate(5);

        foreach ($products as &$product) {
            $product['highrateCounts'] = $product->rates->where('rate_type', '=', '1')->count();
            $product['lowrateCounts'] = $product->rates->where('rate_type', '=', '2')->count();
            $product['reviewCounts'] = $product->reviews->count();

            // 参照渡しの際は、これでメモリを節約
            unset($product);
        }

        return view('productList', compact('products'));
    }
}
