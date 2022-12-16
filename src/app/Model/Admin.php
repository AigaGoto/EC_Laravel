<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $guard = 'admin';
    
    protected $primaryKey = 'admin_id';

    protected $fillable = [
        'admin_name', 
        'admin_email', 
        'admin_password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    // パスワードの設定
    public function getAuthPassword() 
    {
        return $this->admin_password; 
    }
}
