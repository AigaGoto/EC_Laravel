<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    protected $primaryKey = 'admin_id';

    protected $fillable = [
        'admin_name', 
        'admin_email', 
        'admin_password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
}
