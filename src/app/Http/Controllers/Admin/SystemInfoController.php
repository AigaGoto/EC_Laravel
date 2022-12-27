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
        $error_email = System::where('system_name', '=', 'error_email')->first()->system_value;

        return view('admin.systemInfo', compact('error_email'));
    }

    public function update(Request $request)
    {
        $validated_data = $request->validate([
            'error_email' => 'required|string|email|max:100'
        ]);

        DB::beginTransaction();
        try {
            System::where('system_name', '=', 'error_email')->first()
                ->update([
                    'system_value' => $request->error_email,
                ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }


        return redirect()->back();
    }

}
