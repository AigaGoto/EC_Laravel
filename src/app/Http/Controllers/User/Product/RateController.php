<?php

namespace App\Http\Controllers\User\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Model\Rate;

class RateController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($product_id, Request $request)
    {
        Rate::create([
            'rate_type' => $request->rate_type,
            'user_id' => Auth::id(),
            'product_id' => $product_id,
        ]);

        // session()->flash('success', 'You Liked the Reply.');

        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($product_id, $rate_id, Request $request)
    {
        Rate::where('product_id', $product_id)->where('user_id', Auth::id())
            ->update(([
                'rate_type' => $request->rate_type,
                'user_id' => Auth::id(),
                'product_id' => $product_id,
            ]));
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($product_id, $rate_id)
    {
        $rate = Rate::where('product_id', $product_id)->where('user_id', Auth::id())->first();
        $rate->delete();
        return redirect()->back();
    }
}
