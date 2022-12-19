<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $primaryKey = 'log_id';

    protected $fillable = [
        'log_type', 
        'log_table_type', 
        'log_ip_address', 
        'log_user_agent', 
        'user_id', 
        'log_path', 
    ];
}
