<?php

namespace App\Model;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $primaryKey = 'user_id';

    protected $fillable = [
        'user_name', 
        'user_email', 
        'user_password',
        'user_birthday', 
        'user_gender', 
        'user_icon_image',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // パスワードの設定
    public function getAuthPassword() 
    {
        return $this->user_password; 
    }

    public function reviews()
    {
        return $this->hasMany('App\Model\Review', 'user_id');
    }

    public function rates()
    {
        return $this->hasMany('App\Model\Rate', 'user_id');
    }

    public function products()
    {
        return $this->belongsToMany('App\Model\Product', 'order', 'user_id', 'product_id');
    }
}
