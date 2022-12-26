<?php
namespace App\Services;

use App\Model\Log;

class CreateLogService
{
    public function createLog($log_type, $log_type_table, $user_id, $request)
    {
        Log::create([
            'log_type' => $log_type,
            'log_table_type' => $log_type_table,
            'log_ip_address' => $request->ip(),
            'log_user_agent' => $request->header('User-Agent'),
            'user_id' => $user_id,
            'log_path' => $request->path(),
        ]);
    }
}