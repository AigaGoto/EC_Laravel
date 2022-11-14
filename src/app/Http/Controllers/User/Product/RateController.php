<?php

namespace App\Http\Controllers\User\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RateController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function ungood($product_id) {
        $good = Rate::where('product_id', $product_id)->where('user_id', Auth::id())->first();
        $good->delete();

        session()->flash('success', 'You Unliked the Reply.');

        return redirect()->back();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($product_id, $rate_type)
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($product_id, $request)
    {

        dd($request);

        Rate::create([
            'rate_type' => $request->rate_type,
            'user_id' => Auth::id(),
            'product_id' => $request->product_id,
        ]);

        // session()->flash('success', 'You Liked the Reply.');

        return redirect()->back()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($product_id, $rate_type)
    {
        Rate::where('product_id', $product_id)->where('user_id', Auth::id())
            ->update(([
                'rate_type' => $rate_type,
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
    public function destroy($product_id)
    {
        $rate = Rate::where('product_id', $product_id)->where('user_id', Auth::id())->first();
        $rate->delete();
        return redirect()->back();
    }
}
