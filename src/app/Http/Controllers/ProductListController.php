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

        foreach ($products as $key => $value) {
            $products[$key]['highrateCounts'] = $products[$key]->rates->where('rate_type', '=', '1')->count();
            $products[$key]['lowrateCounts'] = $products[$key]->rates->where('rate_type', '=', '2')->count();
            $products[$key]['reviewCounts'] = $products[$key]->reviews->count();
        }

        return view('user/productList', compact('products'));
    }
}
