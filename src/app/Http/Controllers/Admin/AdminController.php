<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Model\Admin;
use App\Model\Log;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $admin_name = $request->input('admin_name');

        $query = Admin::query();

        // 管理者名が入力されているなら、検索する
        if (!empty($admin_name)) {
            $query->where('admin_name', 'LIKE', "%{$admin_name}%");
        }

        $admins = $query->paginate(5);

        return view('admin.admin.index', compact('admins', 'admin_name'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.admin.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'admin_email' => 'required|string|max:100|email|unique:admins',
            'admin_password' => 'required|min:8|confirmed',
            'admin_password_confirmation' => 'required|min:8',
            'admin_name' => 'required|string|max:20',
        ]);

        Admin::create([
            'admin_email' => $request->admin_email,
            'admin_password' => bcrypt($request->admin_password),
            'admin_name' => $request->admin_name,
        ]);

        // ログの作成
        Log::create([
            'log_type' => 1,
            'log_table_type' => 6,
            'log_ip_address' => $request->ip(),
            'log_user_agent' => $request->header('User-Agent'),
            'user_id' => Auth::id(),
            'log_path' => $request->path(),
        ]);

        return redirect()->route('admin.admin.index');
    }
}
