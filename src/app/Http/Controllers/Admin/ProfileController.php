<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Services\CreateLogService;

class ProfileController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        return view('admin.profile');
    }

    public function update(Request $request, CreateLogService $createLogService)
    {
        $validatedData = $request->validate([
            'admin_email' => 'required|string|max:100|email|unique:admins,admin_email,'.Auth::user()->admin_id.',admin_id',
            'admin_name' => 'required|string|max:20',
        ]);

        DB::beginTransaction();
        try {
            Auth::user()->update([
                'admin_name' => $request->admin_name,
                'admin_email' => $request->admin_email,
            ]);

            // ログの作成
            $createLogService->createLog(\Consts::LOG_UPDATE, \Consts::TABLE_ADMIN, Auth::id(), $request);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }


        return redirect()->back();
    }
}
