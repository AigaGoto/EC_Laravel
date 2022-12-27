<?php

namespace App\Http\Controllers\User\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Model\Rate;
use Illuminate\Support\Facades\DB;
use App\Services\CreateLogService;

class RateController extends Controller
{
    public function __construct(CreateLogService $createLogService)
    {
        $this->middleware('auth');
        $this->createLogService = $createLogService;
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

        DB::beginTransaction();
        try {
            Rate::create([
                'rate_type' => $request->rate_type,
                'user_id' => Auth::id(),
                'product_id' => $product_id,
            ]);

            // ログの作成
            $this->createLogService->createLog(\Consts::LOG_REGISTER, \Consts::TABLE_RATE, Auth::id(), $request);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }


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

        DB::beginTransaction();
        try {
            Rate::where('rate_id', $rate_id)
                ->update(([
                    'rate_type' => $request->rate_type,
                ]));

            // ログの作成
            $this->createLogService->createLog(\Consts::LOG_UPDATE, \Consts::TABLE_RATE, Auth::id(), $request);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }


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

        DB::beginTransaction();
        try {
            $rate->delete();

            // ログの作成
            $this->createLogService->createLog(\Consts::LOG_DELETE, \Consts::TABLE_RATE, Auth::id(), $request);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }


        return redirect()->back();
    }
}
