<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Model\Order;
use Illuminate\Support\Facades\DB;

use App\Services\CreateLogService;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function purchaseHistory()
    {
        $orders = Order::with('product')->where('user_id', Auth::id())->paginate(\Consts::PAGINATE_NUM);

        return view('user.purchaseHistory', compact('orders'));
    }

    public function profile()
    {
        return view('user.profile');
    }

    public function profileUpdate(Request $request, CreateLogService $createLogService)
    {
        $validatedData = $request->validate([
            'user_email' => 'required|string|max:100|email|unique:users,user_email,'.Auth::id().',user_id',
            'user_name' => 'required|string|max:20',
            'user_birthday' => 'required|date',
            'user_gender' => 'required|between:1,2',
            'user_icon_image' => 'file|image',
        ]);

        $root_path = 'public/sample/';

        $newImage = $request->file('user_icon_image');

        $file_name = Auth::user()->user_icon_image;

        if(isset($newImage)) {
            \Storage::delete($root_path . $file_name);
            $file_name = Auth::id() ."." . $newImage->getClientOriginalExtension();
            $path = $newImage->storeAs($root_path, $file_name);
        }

        DB::beginTransaction();

        try {
            Auth::user()->update([
                'user_name' => $request->user_name,
                'user_email' => $request->user_email,
                'user_birthday' => $request->user_birthday,
                'user_gender' => $request->user_gender,
                'user_icon_image' => $file_name,
            ]);

            // ログの作成
            $createLogService->createLog(\Consts::LOG_UPDATE, \Consts::TABLE_USER, Auth::id(), $request);

            session()->flash('update_success', '更新が完了しました');

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }

        return redirect()->back();
    }
}
