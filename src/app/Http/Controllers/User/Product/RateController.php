<?php

namespace App\Http\Controllers\User\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Model\Rate;
use App\Model\Log;

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
        $validatedData = $request->validate([
            'rate_type' => 'required|between:1,2',
        ]);

        Rate::create([
            'rate_type' => $request->rate_type,
            'user_id' => Auth::id(),
            'product_id' => $product_id,
        ]);

        // ログの作成
        Log::create([
            'log_type' => 1,
            'log_table_type' => 4,
            'log_ip_address' => $request->ip(),
            'log_user_agent' => $request->header('User-Agent'),
            'user_id' => Auth::id(),
            'log_path' => $request->path(),
        ]);

        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$product_id, $rate_id)
    {
        $validatedData = $request->validate([
            'rate_type' => 'required|between:1,2',
        ]);

        Rate::where('rate_id', $rate_id)
            ->update(([
                'rate_type' => $request->rate_type,
            ]));

        // ログの作成
        Log::create([
            'log_type' => 2,
            'log_table_type' => 4,
            'log_ip_address' => $request->ip(),
            'log_user_agent' => $request->header('User-Agent'),
            'user_id' => Auth::id(),
            'log_path' => $request->path(),
        ]);

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$product_id, $rate_id)
    {
        $rate = Rate::where('rate_id', $rate_id)->first();
        $rate->delete();

        // ログの作成
        Log::create([
            'log_type' => 3,
            'log_table_type' => 4,
            'log_ip_address' => $request->ip(),
            'log_user_agent' => $request->header('User-Agent'),
            'user_id' => Auth::id(),
            'log_path' => $request->path(),
        ]);
        
        return redirect()->back();
    }
}
