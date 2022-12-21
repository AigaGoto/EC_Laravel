<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Log;
use App\Consts\PaginateConst;

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
            foreach($log_types as $log_type){
                $query = $query->orWhere('log_type', $log_type);
            }
            return $query;
        })
        ->paginate(PaginateConst::NUM);

        return view('admin.log', compact('logs', 'log_types'));
    }
}
