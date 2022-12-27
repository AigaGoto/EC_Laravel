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
        $log_types = $request->input('log_type');

        // 管理者名が検索されているなら絞り込む
        $logs = Log::when($log_types, function ($query, $log_types) {
            $query = $query->whereIn('log_type', $log_types);
            return $query;
        })
        ->latest()->paginate(\Consts::PAGINATE_NUM);

        return view('admin.log', compact('logs', 'log_types'));
    }
}
