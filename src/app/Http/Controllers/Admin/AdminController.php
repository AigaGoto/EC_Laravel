<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Model\Admin;
use Illuminate\Support\Facades\DB;

use App\Services\CreateLogService;

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

        // 管理者名が検索されているなら絞り込む
        $admins = Admin::when($admin_name, function ($query, $admin_name) {
            return $query->where('admin_name', 'LIKE', "%{$admin_name}%");
        })
        ->paginate(\Consts::PAGINATE_NUM);

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
    public function store(Request $request, CreateLogService $createLogService)
    {
        $validatedData = $request->validate([
            'admin_email' => 'required|string|max:100|email|unique:admins',
            'admin_password' => 'required|min:8|confirmed',
            'admin_password_confirmation' => 'required|min:8',
            'admin_name' => 'required|string|max:20',
        ]);

        Admin::create([
            'admin_email' => $request->admin_email,
            'admin_password' => Hash::make($request->admin_password),
            'admin_name' => $request->admin_name,
        ]);

        // ログの作成
        $createLogService->createLog(\Consts::LOG_REGISTER, \Consts::TABLE_ADMIN, Auth::id(), $request);

        return redirect()->route('admin.admin.index');
    }
}
