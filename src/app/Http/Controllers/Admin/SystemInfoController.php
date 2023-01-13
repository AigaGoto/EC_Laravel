<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\System;
use Illuminate\Support\Facades\DB;

class SystemInfoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        // エラー通知先メールアドレスを取得
        $error_email = System::where('system_name', '=', 'error_email')->first();

        // 存在しなかったらnull, 存在したら値を取得
        if(!empty($error_email)) $error_email = $error_email->system_value;

        return view('admin.systemInfo', compact('error_email'));
    }

    public function update(Request $request)
    {
        $validated_data = $request->validate([
            'error_email' => 'required|string|email|max:100'
        ]);

        DB::beginTransaction();
        try {
            $error_email = System::updateOrCreate(
                    ['system_name' => 'error_email'],
                    ['system_value' => $request->error_email],
                );

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }


        return redirect()->back();
    }

}
