<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Log;

class LogController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    
    public function index(Request $request)
    {
        $log_type = $request->input('log_type');

        $query = Log::query();

        // 操作名がチェックされているなら、検索する
        // if (!empty($log_type)) {
        //     $query->where('log_type', 'LIKE', "%{$log_type}%");
        // }

        $logs = $query->paginate(5);

        return view('admin.log', compact('logs'));
    }
}
