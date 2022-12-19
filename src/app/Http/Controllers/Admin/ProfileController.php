<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Model\Log;

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

    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'admin_email' => 'required|string|max:100|email|unique:admins,admin_email,'.Auth::user()->admin_id.',admin_id',
            'admin_name' => 'required|string|max:20',
        ]);

        Auth::user()->update([
            'admin_name' => $request->admin_name,
            'admin_email' => $request->admin_email,
        ]);

        // ログの作成
        Log::create([
            'log_type' => 2,
            'log_table_type' => 6,
            'log_ip_address' => $request->ip(),
            'log_user_agent' => $request->header('User-Agent'),
            'user_id' => Auth::id(),
            'log_path' => $request->path(),
        ]);

        return redirect()->back();
    }
}
